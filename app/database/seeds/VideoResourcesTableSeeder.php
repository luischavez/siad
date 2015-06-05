<?php

class VideoResourcesTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('video_resources')) {
			return;
		}

		DB::table('video_resources')->delete();

		DB::table('video_resources')->insert(
			array('resource_id' => 1, 'url' => 'http://www.youtube.com/watch?v=VwyNxNSjv-0')
		);
	}
}