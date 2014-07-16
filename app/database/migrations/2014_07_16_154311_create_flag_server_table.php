<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlagServerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flag_server', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('server_id')->unsigned()->index();
			$table->integer('flag_id')->unsigned()->index();

			$table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
			$table->foreign('flag_id')->references('id')->on('flags')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flag_server');
	}

}
