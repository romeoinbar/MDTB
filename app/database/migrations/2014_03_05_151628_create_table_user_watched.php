<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableUserWatched extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_watched', function($table) {
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->integer('title_id')->unsigned();
			$table->string('title_type');
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
		Schema::drop('user_watched');
	}

}