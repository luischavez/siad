<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users_courses', function($table) {
			$table->integer('user_id')->unsigned();
			$table->integer('course_id')->unsigned();

			$table->primary(array('user_id', 'course_id'));
			$table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users_courses');
	}

}