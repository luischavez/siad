<?php

class AnswersTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('answers')) {
			return;
		}

		DB::table('answers')->delete();

		DB::table('answers')->insert(array(
			array('question_id' => 1, 'answer_text' => 'if', 'is_correct' => TRUE),
			array('question_id' => 1, 'answer_text' => 'for', 'is_correct' => TRUE),
			array('question_id' => 1, 'answer_text' => 'while', 'is_correct' => TRUE),
			array('question_id' => 1, 'answer_text' => 'new', 'is_correct' => FALSE)
		));
	}
}