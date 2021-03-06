<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('CoursesTableSeeder');
		$this->call('TestsTableSeeder');
		$this->call('QuestionsTableSeeder');
		$this->call('AnswersTableSeeder');
		$this->call('ResourcesTableSeeder');
		$this->call('VideoResourcesTableSeeder');
		$this->call('FileResourcesTableSeeder');
		$this->call('UrlResourcesTableSeeder');
		$this->call('UsersCoursesTableSeeder');
		$this->call('UsersTestsTableSeeder');
		//$this->call('UsersAnswersTableSeeder');
	}
}