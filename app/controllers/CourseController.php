<?php

class CourseController extends BaseController {

	protected $layout = 'layouts.default';

	public function lists() {
		$teacherCourses = Auth::user()->teacherCourses;
		$studentCourses = Auth::user()->studentCourses;

		$this->layout->content = View::make('courses.lists')
			->with('teacherCourses', $teacherCourses)
			->with('studentCourses', $studentCourses);
	}

	public function add() {
		$this->layout->content = View::make('courses.add');
	}

	public function create() {
		$input = Input::only('course_name', 'description', 'password');

		$user = Auth::user();

		$validator = Validator::make($input,
			array(
				'course_name' => 'required|min:10|max:120',
				'description' => 'max:500',
				'password' => 'max:20'
			)
		);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$input['created_at'] = Carbon::now();

		$course = new Course($input);

		$user->teacherCourses()->save($course);

		return Redirect::route('course.manager', $course->course_id);
	}

	public function edit(Course $course) {
		$this->layout->content = View::make('courses.edit')
			->with('course', $course);
	}

	public function update(Course $course) {
		$input = Input::only('course_name', 'description', 'password');

		$validator = Validator::make($input,
			array(
				'course_name' => 'required|min:10|max:120',
				'description' => 'max:500',
				'password' => 'max:20'
			)
		);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$course->update($input);

		return Redirect::route('course.manager', $course->course_id);
	}

	public function start(Course $course) {
		$course->started_at = Carbon::now();
		$course->closed_at = NULL;
		$course->save();

		return Redirect::route('course.manager', $course->course_id);
	}

	public function close(Course $course) {
		$course->students->each(function($student) use ($course) {
			$totalTests = 0;
			$qualification = 0;

			$course->tests->each(function($test) use ($student, &$totalTests, &$qualification) {
				if ($test->hasQualification($student) || $test->isFinalized()) {
					$totalTests++;

					if (!$test->students->contains($student->user_id)) {
						$test->students()->attach($student->user_id);
					} else {
						$qualification += $test->students->find($student->user_id)->pivot->qualification;
					}
				}
			});

			$student->questions->each(function($question) use ($student, $course) {
				if ($course->course_id == $question->test->course->course_id) {
					$student->questions()->detach($question->question_id);
				}
			});

			$student->tests->each(function($test) use ($student, $course) {
				if ($course->course_id == $test->course->course_id) {
					$student->tests()->detach($test->test_id);
				}
			});

			if ($totalTests) {
				$qualification /= $totalTests;
			}

			Kardex::create(array(
				'user_id' => $student->user_id,
				'course_name' => $course->course_name,
				'status' => $totalTests ? 'qualified' : 'completed',
				'qualification' => $qualification
			));
		});

		$course->students()->detach();

		$course->tests->each(function($test) {
			$test->time = 0;
			$test->start_date = NULL;
			$test->end_date = NULL;

			$test->save();
		});

		$course->started_at = NULL;
		$course->closed_at = Carbon::now();
		$course->save();

		return Redirect::route('course.manager', $course->course_id);
	}

	public function manager(Course $course) {
		$this->layout->content = View::make('courses.manager')
			->with('course', $course);
	}

	public function view(Course $course) {
		$this->layout->content = View::make('courses.view')
			->with('course', $course);
	}

	public function register(Course $course) {
		$this->layout->content = View::make('courses.register')
			->with('course', $course);
	}

	public function subscribe(Course $course) {
		if ($course->password) {
			$input = Input::only('password');

			$validator = Validator::make($input,
				array(
					'password' => 'required',
				)
			);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput($input);
			}

			if ($course->password != $input['password']) {
				Session::push('messages', array('type' => 'danger', 'text' => 'Contraseña invalida!'));

				return Redirect::back()->withInput($input);
			}
		}

		$course->students()->attach(Auth::user()->user_id);

		return Redirect::route('course.view', $course->course_id);
	}

	public function unsubscribe($course) {
		$user = Auth::user();

		if ($course->students()->detach($user->user_id)) {
			Session::push('messages', array('type' => 'info', 'text' => "Diste de baja el curso '$course->course_name'"));

			$user->questions->each(function($question) use ($user, $course) {
				if ($course->course_id == $question->test->course->course_id) {
					$user->questions()->detach($question->question_id);
				}
			});

			$user->tests->each(function($test) use ($user, $course) {
				if ($course->course_id == $test->course->course_id) {
					$user->tests()->detach($test->test_id);
				}
			});

			Kardex::create(array(
				'user_id' => $user->user_id,
				'course_name' => $course->course_name,
				'status' => 'unsubscribe',
				'qualification' => 0
			));
		} else {
			Session::push('messages', array('type' => 'warning', 'text' => "El curso '$course->course_name' no se pudo dar de baja"));
		}

		return Redirect::route('course.lists');
	}

	public function cancel(Course $course) {
		$resources = $course->resources;
		
		if ($course->delete()) {
			Session::push('messages', array('type' => 'info', 'text' => "Cancelaste el curso '$course->course_name'"));
			
			$resources->each(function($resource) {
				if (File::exists('uploads/resources/' . $resource->resource_id)) {
					File::delete('uploads/resources/' . $resource->resource_id);
				}
			});
		} else {
			Session::push('messages', array('type' => 'warning', 'text' => "El curso '$course->course_name' no se pudo cancelar"));
		}

		return Redirect::route('course.lists');
	}

	public function qualifications(Course $course) {
		$user = Auth::user();

		$course->tests->each(function($test) use ($user) {
			if (!$test->students->contains($user->user_id)) {
				if ($test->isExpired($user)) {
					$test->students()->attach($user->user_id);
				}
			}
		});

		$this->layout->content = View::make('courses.qualifications')
			->with('course', $course);
	}
}