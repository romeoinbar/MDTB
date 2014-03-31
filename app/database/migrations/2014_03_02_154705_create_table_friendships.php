<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableFriendships extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('friendships', function($table) {
			$table->increments('id');
			$table->integer('first_user');
			$table->integer('second_user');
			$table->integer('status');
			$table->timestamps();

			$table->index('first_user');
			$table->index('second_user');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('friendships');
	}

}