<?php 

class ResourcesTableSeeder extends Seeder {

	public function run() {
		if (!Schema::hasTable('resources')) {
			return;
		}

		DB::table('resources')->delete();

		DB::table('resources')->insert(array(
			array('course_id' => 1, 'title' => 'Tutorial de java #1', 'description' => 'Estructuras de control.', 'type' => 'video', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
			array('course_id' => 1, 'title' => 'Ejemplos de estructuras de control', 'description' => 'Pdf con ejemplos.', 'type' => 'file', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
			array('course_id' => 1, 'title' => 'Libro de java', 'description' => 'Libro de ejemplos.', 'type' => 'url', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now())
		));
	}
}