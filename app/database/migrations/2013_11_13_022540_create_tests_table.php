<?php

use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tests', function($table) {
			$table->increments('test_id')->unsigned();
			$table->integer('course_id')->unsigned();
			$table->string('title', 120);
			$table->text('description')->nullable();
			$table->integer('time')->unsigned();
			$table->timestamp('start_date')->nullable();
			$table->timestamp('end_date')->nullable();
			$table->timestamp('created_at');

			$table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('tests');
	}
}