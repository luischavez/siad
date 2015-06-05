<?php

use Illuminate\Database\Migrations\Migration;

class CreateVideoResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('video_resources', function($table) {
			$table->integer('resource_id')->unsigned();
			$table->text('url');

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
		Schema::dropIfExists('video_resources');
	}
}