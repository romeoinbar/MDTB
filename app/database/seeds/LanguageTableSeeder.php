<?php
class LanguageTableSeeder extends Seeder {
	public function run() {
		DB::table('languages')->truncate();

		$date = date('Y-m-d H:i:s');
		$toInsert = array(
			array(
				'id'			=> 1,
				'name'			=> 'English',
				'icon'			=> 'assets/images/flag_en.png',
				'created_at'	=> $date,
				'updated_at'	=> $date
			),
			array(
				'id'			=> 2,
				'name'			=> 'France',
				'icon'			=> 'assets/images/flag_fr.png',
				'created_at'	=> $date,
				'updated_at'	=> $date
			)
		);

		DB::table('languages')->insert($toInsert);
	}
}