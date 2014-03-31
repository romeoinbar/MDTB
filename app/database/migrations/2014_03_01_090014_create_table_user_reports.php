<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableUserReports extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_reports', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id');
			$table->integer('link_id');
			$table->timestamps();

			$table->index('user_id');
			$table->index('link_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_reports');
	}

}