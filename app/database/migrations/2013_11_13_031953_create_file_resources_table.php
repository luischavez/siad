<?php

use Illuminate\Database\Migrations\Migration;

class CreateFileResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('file_resources', function($table) {
			$table->integer('resource_id')->unsigned();
			$table->text('file_name');
			$table->boolean('is_pdf')->default(FALSE);

			$table->primary('resource_id');
			$table->foreign('resource_id')->references('resource_id')->on('resources')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('file_resources');
	}
}