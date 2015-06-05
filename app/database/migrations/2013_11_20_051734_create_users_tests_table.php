<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users_tests', function($table) {
			$table->integer('user_id')->unsigned();
			$table->integer('test_id')->unsigned();
			$table->timestamp('started_at')->nullable();
			$table->boolean('is_finished')->default(FALSE);
			$table->double('qualification')->default(0);

			$table->primary(array('user_id', 'test_id'));
			$table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('test_id')->references('test_id')->on('tests')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users_tests');
	}
}