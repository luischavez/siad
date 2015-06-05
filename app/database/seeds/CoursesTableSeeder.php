<?php

class CoursesTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('courses')) {
			return;
		}

		DB::table('courses')->delete();

		DB::table('courses')->insert(array(
			array('teacher_id' => 1, 'course_name' => 'Curso de java', 'description' => 'Curso completo de java basico.', 'password' => NULL, 'created_at' => Carbon::now(), 'started_at' => Carbon::now(), 'closed_at' => NULL),
			array('teacher_id' => 2, 'course_name' => 'Curso de java 2', 'description' => 'Curso completo de java basico.', 'password' => NULL, 'created_at' => Carbon::now(), 'started_at' => Carbon::now(), 'closed_at' => NULL)
		));
	}
}