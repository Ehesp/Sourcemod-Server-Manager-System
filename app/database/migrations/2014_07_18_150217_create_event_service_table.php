<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_service', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('event_id')->unsigned()->index();
			$table->integer('service_id')->unsigned()->index();

			$table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_service');
	}

}
