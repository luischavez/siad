<?php

class UsersTestsTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('users_tests')) {
			return;
		}

		DB::table('users_tests')->delete();

		DB::table('users_tests')->insert(
			array('user_id' => 2, 'test_id' => 1, 'started_at' => Carbon::now(), 'is_finished' => true, 'qualification' => 10)
		);
	}
}