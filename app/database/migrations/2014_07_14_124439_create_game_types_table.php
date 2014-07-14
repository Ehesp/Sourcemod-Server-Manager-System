<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('acronym');
			$table->integer('app_id');
			$table->string('version');
			$table->integer('min_players')->nullable();
			$table->text('icon')->nullable();
			$table->text('logo')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('game_types');
	}

}
