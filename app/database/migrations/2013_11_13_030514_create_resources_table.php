<?php

use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('resources', function($table) {
			$table->increments('resource_id')->unsigned();
			$table->integer('course_id')->unsigned();
			$table->string('title', 120);
			$table->text('description')->nullable();
			$table->enum('type', array('video', 'file', 'url'))->default('url');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');

			$table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('resources');
	}
}