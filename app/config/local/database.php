<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => isset($_ENV['database.host']) ? $_ENV['database.host'] : 'localhost',
			'database'  => isset($_ENV['database.name']) ? $_ENV['database.name'] : 'database',
			'username'  => isset($_ENV['database.user']) ? $_ENV['database.user'] : 'user',
			'password'  => isset($_ENV['database.password']) ? $_ENV['database.password'] : 'password',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

	),

);