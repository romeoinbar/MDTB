<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableEpisodeLinks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('episode_links', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('episode_id');
			$table->integer('language_id');
			$table->integer('user_id');
			$table->string('url');
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
		Schema::drop('episode_links');
	}

}