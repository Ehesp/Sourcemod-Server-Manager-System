<?php

/*
|--------------------------------------------------------------------------
| Dashboard redirect
|--------------------------------------------------------------------------
|
| To validate page access and avoid confusion, we redirect the user
| to the 'dashboard' route if they hit the document root
|
*/

Route::get('/', function() { return Redirect::route('dashboard'); });

/*
|--------------------------------------------------------------------------
| Access Required Routes
|--------------------------------------------------------------------------
|
| These routes first undergo an 'access' filter check, by matching the
| first segment within the URI with the pages they're allowed to access
| which are pulled from the IoC container.
|
*/

Route::group(['before' => 'access'], function()
{
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@getView']);

	Route::get('servers', ['as' => 'servers', 'uses' => 'ServerController@getView']);

	Route::get('active-plugins', ['as' => 'active-plugins', 'uses' => 'PluginController@getView']);

	Route::get('multi-console', ['as' => 'multi-console', 'uses' => 'ConsoleController@getView']);

	Route::get('admin-activity', ['as' => 'admin-activity', 'uses' => 'AdminController@getView']);

	Route::get('game-types', ['as' => 'game-types', 'uses' => 'GameTypeController@getView']);

	Route::group(['prefix' => 'settings'], function()
	{
		Route::get('/', ['as' => 'settings', 'uses' => 'SettingController@getView']);

		Route::get('users', ['as' => 'settings.users', 'uses' => 'SettingController@getUsersView']);
	});
	

});

Route::group(['before' => 'auth'], function()
{
	Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@getView']);	
});
/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
*/

Route::get('login', 'AuthController@validateSteamLogin');

Route::get('logout', 'AuthController@logout');