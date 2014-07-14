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

	Route::group(['prefix' => 'servers'], function()
	{
		Route::get('/', ['as' => 'servers', 'uses' => 'ServerController@getView']);
		Route::post('/', ['before' => 'ajax', 'uses' => 'ServerController@getServers']);
	});

	Route::get('active-plugins', ['as' => 'active-plugins', 'uses' => 'PluginController@getView']);

	Route::get('multi-console', ['as' => 'multi-console', 'uses' => 'ConsoleController@getView']);

	Route::get('admin-activity', ['as' => 'admin-activity', 'uses' => 'AdminController@getView']);

	Route::get('game-types', ['as' => 'game-types', 'uses' => 'GameTypeController@getView']);

	Route::group(['prefix' => 'settings'], function()
	{
		Route::get('/', ['as' => 'settings', 'uses' => 'SettingController@getView']);

		Route::group(['prefix' => 'users'], function()
		{
			Route::get('/', ['as' => 'settings.users', 'before' => 'permission:settings.users', 'uses' => 'SettingController@getUsersView']);
			Route::post('/', ['before' => 'ajax|permissions:settings.users', 'uses' => 'SettingController@getUsers']);
			Route::post('delete', ['before' => 'ajax|permissions:settings.users.delete', 'uses' => 'SettingController@deleteUser']);
			Route::post('edit', ['before' => 'ajax|permissions:settings.users.edit', 'uses' => 'SettingController@editUser']);
			Route::post('add', ['before' => 'ajax|permissions:settings.users.add', 'uses' => 'SettingController@addUser']);
			Route::post('add/search', ['before' => 'ajax|permissions:settings.users.add', 'uses' => 'SettingController@userSearch']);
			Route::post('refresh/{id?}', ['before' => 'ajax|permissions:settings.users.refresh', 'uses' => 'SettingController@refreshUser']);
		});

		Route::group(['prefix' => 'options', 'before' => 'permission:settings.options'], function()
		{
			Route::get('/', ['as' => 'settings.options', 'uses' => 'SettingController@getOptionsView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'SettingController@getOptions']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'SettingController@editOption']);
		});

		Route::group(['prefix' => 'page-management', 'before' => 'permission:settings.page_access'], function()
		{
			Route::get('/', ['as' => 'settings.page-management', 'uses' => 'SettingController@getPageManagementView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'SettingController@getPages']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'SettingController@editPage']);
		});

		Route::group(['prefix' => 'permission-control', 'before' => 'permission:settings.permission_control'], function()
		{
			Route::get('/', ['as' => 'settings.permission-control', 'uses' => 'SettingController@getPermissionControlView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'SettingController@getPermissions']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'SettingController@editPermission']);
		});

		Route::group(['prefix' => 'quick-links', 'before' => 'permission:settings.permission_control'], function()
		{
			Route::get('/', ['as' => 'settings.quick-links', 'uses' => 'SettingController@getQuickLinksView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'SettingController@getQuickLinks']);
			Route::post('delete', ['before' => 'ajax', 'uses' => 'SettingController@deleteQuickLink']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'SettingController@editQuickLink']);
			Route::post('add', ['before' => 'ajax', 'uses' => 'SettingController@addQuickLink']);
		});
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