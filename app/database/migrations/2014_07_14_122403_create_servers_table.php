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
			$table->integer('client_appid');
			$table->string('name');
			$table->string('ip');
			$table->integer('port');
			$table->string('tags')->nullable();
			$table->longText('rcon_password');
			$table->integer('multi_console');
			$table->string('operating_system');
			$table->string('version');
			$table->string('network');
			$table->string('current_map');
			$table->integer('current_players');
			$table->integer('current_bots')->nullable();
			$table->integer('max_players');
			$table->integer('auto_update');
			$table->integer('retries')->default(0);
			$table->integer('hidden');
			$table->string('start_map')->nullable();
			$table->integer('daily_restart')->default(0);
			$table->string('daily_restart_time')->nullable();
			$table->string('daily_restart_commands')->nullable();
			
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
