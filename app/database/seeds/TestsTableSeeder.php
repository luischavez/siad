<?php

class TestsTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('tests')) {
			return;
		}

		DB::table('tests')->delete();

		DB::table('tests')->insert(
			array('course_id' => 1, 'title' => 'Examen de estructuras de control', 'description' => '', 'time' => 60, 'start_date' => Carbon::now()->tomorrow(), 'end_date' => Carbon::now()->tomorrow()->tomorrow(), 'created_at' => Carbon::now())
		);
	}
}