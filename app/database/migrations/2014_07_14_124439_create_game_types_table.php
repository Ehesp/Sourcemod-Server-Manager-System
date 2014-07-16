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
			$table->integer('client_appid')->unique();
			$table->string('hldsid');
			$table->string('gamename');
			$table->string('version');
			$table->integer('expired')->default(0);
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
