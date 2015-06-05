<?php

class QuestionController extends BaseController {

	protected $layout = 'layouts.default';

	public function add(Test $test, $type) {
		$this->layout->content = View::make('questions.add')
			->with('course', $test->course)
			->with('test', $test)
			->with('type', $type);
	}

	public function create(Test $test) {
		$input = Input::only('question_text', 'type', 'points', 'answer_text', 'is_correct');

		$validator = Validator::make($input, array(
			'question_text' => 'required|min:3|max:200',
			'points' => 'required|numeric|min:1'
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$min = 'open' == $input['type'] ? 1 : 2;

		$answerText = Input::get('answer_text', array());
		$isCorrect = Input::get('is_correct', array());

		if (!is_array($answerText) || !is_array($isCorrect)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => 'No se puede agregar la pregunta'
			));

			return Redirect::back()->withInput($input);
		}

		if (count($answerText) !== count($isCorrect)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => 'No se puede agregar la pregunta'
			));

			return Redirect::back()->withInput($input);
		}

		if ($min > count($answerText)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => "Tiene que existir por lo menos $min respuesta(s)"
			));

			return Redirect::back()->withInput($input);
		}

		$correctCount = 0;

		for ($i = 0; $i < count($answerText); $i++) { 
			if (1 == $isCorrect[$i] && '' != $answerText[$i]) {
				$correctCount++;
			}
		}

		if (0 === $correctCount) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => 'Tiene que existir por lo menos una respuesta correcta'
			));

			return Redirect::back()->withInput($input);
		}

		$question = new Question($input);

		$test->questions()->save($question);

		for ($i = 0; $i < count($answerText); $i++) {
			if ('' != $answerText[$i]) {
				$answer = new Answer(array(
					'answer_text' => $answerText[$i],
					'is_correct' => 1 == $isCorrect[$i]
				));

				$question->answers()->save($answer);
			}
		}

		return Redirect::route('test.manager', $test->test_id);
	}

	public function edit(Test $test, Question $question) {
		$this->layout->content = View::make('questions.edit')
			->with('course', $test->course)
			->with('test', $test)
			->with('question', $question);
	}

	public function update(Test $test, Question $question) {
		$input = Input::only('question_text', 'points', 'answer_text', 'is_correct');

		$validator = Validator::make($input, array(
			'question_text' => 'required|min:3|max:200',
			'points' => 'required|numeric|min:1'
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$answerText = Input::get('answer_text', array());
		$isCorrect = Input::get('is_correct', array());

		if (!is_array($answerText) || !is_array($isCorrect)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => 'No se puede agregar la pregunta'
			));

			return Redirect::back()->withInput($input);
		}

		if (count($answerText) !== count($isCorrect)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => 'No se puede agregar la pregunta'
			));

			return Redirect::back()->withInput($input);
		}

		if (0 === count($answerText)) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => 'Tiene que existir por lo menos una respuesta'
			));

			return Redirect::back()->withInput($input);
		}

		$correctCount = 0;

		for ($i = 0; $i < count($answerText); $i++) { 
			if (1 == $isCorrect[$i] && '' != $answerText[$i]) {
				$correctCount++;
				break;
			}
		}

		if (0 === $correctCount) {
			Session::push('messages', array(
				'type' => 'danger',
				'text' => 'Tiene que existir por lo menos una respuesta correcta'
			));

			return Redirect::back()->withInput($input);
		}

		$question->update($input);
		$question->answers()->delete();

		for ($i = 0; $i < count($answerText); $i++) { 
			$answer = new Answer(array(
				'answer_text' => $answerText[$i],
				'is_correct' => 1 == $isCorrect[$i]
			));

			$question->answers()->save($answer);
		}

		return Redirect::route('test.manager', $test->test_id);
	}

	public function delete(Test $test, Question $question) {
		$question->delete();

		return Redirect::route('test.manager', $test->test_id);
	}
}