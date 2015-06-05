<?php

class TestController extends BaseController {

	protected $layout = 'layouts.default';

	public function add(Course $course) {
		$this->layout->content = View::make('tests.add')
			->with('course', $course);
	}

	public function create(Course $course) {
		$input = Input::only('title', 'description');

		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500'
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$input = array_add($input, 'time', 0);
		$input = array_add($input, 'created_at', Carbon::now());

		$test = new Test($input);

		$course->tests()->save($test);

		return Redirect::route('course.manager', $course->course_id);
	}

	public function edit(Test $test) {
		$this->layout->content = View::make('tests.edit')
			->with('course', $test->course)
			->with('test', $test);
	}

	public function update(Test $test) {
		$input = Input::only('title', 'description');

		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500'
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$test->update($input);

		return Redirect::route('course.manager', $test->course->course_id);
	}

	public function delete(Test $test) {
		$test->delete();

		return Redirect::route('course.manager', $test->course->course_id);
	}

	public function manager(Test $test) {
		$this->layout->content = View::make('tests.manager')
			->with('course', $test->course)
			->with('test', $test);
	}

	public function publish(Course $course, Test $test) {
		$this->layout->content = View::make('tests.publish')
			->with('course', $test->course)
			->with('test', $test);
	}

	public function doPublish(Course $course, Test $test) {
		$input = Input::only('start_date', 'end_date', 'time');

		$validator = Validator::make($input, array(
			'start_date' => 'required|date',
			'end_date' => 'required|date',
			'time' => 'required|numeric|min:1',
		));
		
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$now = Carbon::now();
		$startDate = Carbon::createFromFormat('Y-m-d H:i', $input['start_date']);
		$endDate = Carbon::createFromFormat('Y-m-d H:i', $input['end_date']);

		if ($now->gt($startDate)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => "La fecha de inicio no puede ser menor a la fecha actual."
			));

			return Redirect::back()->withInput($input);
		}

		if ($startDate->gt($endDate)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => "La fecha de cierre no puede ser menor a la fecha de inicio."
			));

			return Redirect::back()->withInput($input);
		}

		if ($startDate->eq($endDate)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => "Las fechas de inicio y cierre no pueden ser iguales."
			));

			return Redirect::back()->withInput($input);
		}

		$test->start_date = $startDate;
		$test->end_date = $endDate;
		$test->time = $input['time'];
		$test->save();

		return Redirect::route('course.manager', $test->course->course_id);
	}

	public function info(Test $test) {
		$user = Auth::user();

		if ($test->isExpired($user)) {
			$test->students()->attach($user->user_id);

			return Redirect::route('test.info', $test->test_id);
		}

		$this->layout->content = View::make('tests.info')
			->with('course', $test->course)
			->with('test', $test);
	}

	public function view(Test $test) {
		$now = Carbon::now();

		if (!$test->students->contains(Auth::user()->user_id)) {
			$startedAt = $now->format('Y-m-d H:i:s');

			$test->students()->attach(Auth::user()->user_id, array(
				'started_at' => $startedAt
			));
		} else {
			$startedAt = $test->students->find(Auth::user()->user_id)->pivot->started_at;
		}		
		
		$start = Carbon::createFromFormat('Y-m-d H:i:s', $startedAt);
		$end = $start->copy()->addMinutes($test->time);

		$seconds = ($test->time * 60) - $now->diffInSeconds($start);

		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds - ($hours * 3600)) / 60);
		$seconds = $seconds - ($hours * 3600) - ($minutes * 60);

		if (1 === strlen($hours)) $hours = "0$hours";
		if (1 === strlen($minutes)) $minutes = "0$minutes";
		if (1 === strlen($seconds)) $seconds = "0$seconds";

		$time = "$hours:$minutes:$seconds";

		$userQuestions = Auth::user()->questions->filter(function($question) use ($test) {
			if ($test->test_id === $question->test->test_id) {
				return $question;
			}
		});

		$this->layout->content = View::make('tests.view')
			->with('course', $test->course)
			->with('test', $test)
			->with('time', $time)
			->with('userQuestions', $userQuestions);
	}

	public function submit(Test $test) {
		$user = Auth::user();

		$user->questions->each(function($question) use ($user, $test) {
			if ($test->test_id == $question->test->test_id) {
				$user->questions()->detach($question->question_id);
			}
		});

		$input = Input::all();

		foreach ($input as $key => $value) {
			if (starts_with($key, 'question')) {
				$questionId = substr($key, strlen('question'));

				$question = Question::find($questionId);

				if ($question) {
					if (is_array($value)) {
						foreach ($value as $text) {
							$user->questions()->attach($questionId, array('answer_text' => $text));
						}
					} else {
						if ($value !== '') {
							$user->questions()->attach($questionId, array('answer_text' => $value));
						}
					}
				}
			}
		}

		if (Input::has('save')) {
			return Redirect::back();
		}

		$user = User::find($user->user_id);

		$pivot = $user->tests->find($test->test_id)->pivot;

		$pivot->is_finished = true;

		$userPoints = $test->userPoints($user);
		$totalPoints = $test->totalPoints();

		$qualification = ($userPoints / $totalPoints) * 100.0;
		
		$pivot->qualification = $qualification;
		$pivot->save();

		return Redirect::route('test.info', $test->test_id);
	}

	public function qualifications(Test $test) {
		$this->layout->content = View::make('tests.qualifications')
			->with('course', $test->course)
			->with('test', $test);
	}
}