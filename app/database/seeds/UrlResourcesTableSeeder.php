<?php

class UrlResourcesTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('url_resources')) {
			return;
		}

		DB::table('url_resources')->delete();

		DB::table('url_resources')->insert(
			array('resource_id' => 3, 'url' => 'http://www.somepage.com/java.pdf')
		);
	}
}