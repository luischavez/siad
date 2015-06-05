<?php

class FileResourcesTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('file_resources')) {
			return;
		}

		DB::table('file_resources')->delete();

		DB::table('file_resources')->insert(
			array('resource_id' => 2, 'file_name' => 'ejemplos_java_1.pdf', 'is_pdf' => TRUE)
		);
	}
}