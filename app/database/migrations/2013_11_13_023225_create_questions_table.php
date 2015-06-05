<?php

use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('questions', function($table) {
			$table->increments('question_id')->unsigned();
			$table->integer('test_id')->unsigned();
			$table->text('question_text');
			$table->enum('type', array('open', 'choice', 'multiple'))->default('open');
			$table->integer('points')->unsigned();

			$table->foreign('test_id')->references('test_id')->on('tests')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('questions');
	}
}