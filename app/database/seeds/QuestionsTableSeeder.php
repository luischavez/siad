<?php

class QuestionsTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('questions')) {
			return;
		}

		DB::table('questions')->delete();

		DB::table('questions')->insert(
			array('test_id' => 1, 'question_text' => 'Selecciona las estructuras de control', 'type' => 'multiple', 'points' => 1)
		);
	}
}