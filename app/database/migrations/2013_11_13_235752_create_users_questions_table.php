<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users_questions', function($table) {
			$table->integer('user_id')->unsigned();
			$table->integer('question_id')->unsigned();
			$table->text('answer_text');

			$table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('question_id')->references('question_id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users_questions');
	}

}