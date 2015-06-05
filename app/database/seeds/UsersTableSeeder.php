<?php

class UsersTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('users')) {
			return;
		}

		DB::table('users')->delete();

		DB::table('users')->insert(array(
			array('first_name' => 'Luis', 'last_name' => 'Chavez', 'email' => 'Frost_Leviathan@hotmail.com', 'user_name' => 'leviathan', 'password' => Hash::make('secret')),
			array('first_name' => 'Luis', 'last_name' => 'Chavez', 'email' => 'luis_13_30_4@hotmail.com', 'user_name' => 'luischavez', 'password' => Hash::make('secret'))
		));
	}
}