<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('triggers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('friendly_name');
			$table->string('value');
			$table->text('options')->nullable();
			$table->string('description');
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
		Schema::drop('triggers');
	}

}
