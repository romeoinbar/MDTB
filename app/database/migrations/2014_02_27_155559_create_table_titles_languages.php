<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableTitlesLanguages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('titles_languages', function($table) {
			$table->increments('id');
			$table->integer('title_id');
			$table->integer('language_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('titles_languages');
	}

}