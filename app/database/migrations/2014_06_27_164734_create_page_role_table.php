<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_role', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('page_id')->unsigned()->index();
			$table->integer('role_id')->unsigned()->index();

			$table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

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
		Schema::drop('page_role');
	}

}
