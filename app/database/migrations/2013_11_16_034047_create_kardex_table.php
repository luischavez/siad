<?php

use Illuminate\Database\Migrations\Migration;

class CreateKardexTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('kardex', function($table) {
			$table->integer('user_id')->unsigned();
			$table->string('course_name', 50);
			$table->string('status', 40);
			$table->double('qualification')->nullable();

			$table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('kardex');
	}
}