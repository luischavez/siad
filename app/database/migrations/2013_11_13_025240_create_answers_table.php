<?php

use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('answers', function($table) {
			$table->increments('answer_id')->unsigned();
			$table->integer('question_id')->unsigned();
			$table->text('answer_text');
			$table->boolean('is_correct')->default(FALSE);

			$table->foreign('question_id')->references('question_id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('answers');
	}
}