<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableLinks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function($table) {
			$table->bigIncrements('id')->unsigned;
			$table->integer('title_id')->nullable();
			$table->integer('episode_id')->nullable();
			$table->integer('language_id');
			$table->integer('user_id');
			$table->string('url');
			$table->string('embed_code');
			$table->integer('reported')->default(0);
			$table->integer('is_new')->default(1);
			$table->integer('views')->default(0);
			$table->timestamps();

			$table->index('title_id');
			$table->index('language_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('links');
	}

}