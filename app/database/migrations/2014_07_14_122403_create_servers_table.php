<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('servers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('ip');
			$table->integer('port');
			$table->string('tags')->nullable();
			$table->text('rcon_password');
			$table->integer('multi_console')->default(1);
			$table->integer('game_type')->unsigned();
			$table->string('operating_system');
			$table->string('version');
			$table->string('network');
			$table->string('start_map');
			$table->string('current_map');
			$table->integer('current_players')->default(0);
			$table->integer('current_bots')->nullable();
			$table->integer('max_players')->default(0);
			$table->integer('auto_update')->default(0);
			$table->integer('show_motd')->default(1);
			$table->integer('retries')->default(0);
			$table->integer('daily_restart')->default(0);
			
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
		Schema::drop('servers');
	}

}
