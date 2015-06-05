<?php

use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('courses', function($table) {
			$table->increments('course_id')->unsigned();
			$table->integer('teacher_id')->unsigned();
			$table->string('course_name', 120);
			$table->text('description');
			$table->string('password', 20)->nullable();
			$table->timestamp('created_at');
			$table->timestamp('started_at')->nullable();
			$table->timestamp('closed_at')->nullable();

			$table->foreign('teacher_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('courses');
	}
}