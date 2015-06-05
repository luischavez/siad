<?php

class UsersCoursesTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('users_courses')) {
			return;
		}

		DB::table('users_courses')->delete();

		DB::table('users_courses')->insert(array(
			array('user_id' => 1, 'course_id' => 2),
			array('user_id' => 2, 'course_id' => 1)
		));
	}
}