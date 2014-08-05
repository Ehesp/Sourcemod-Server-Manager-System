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
        Route::get('/json', 'ServerController@getServersJson');
		Route::post('/', ['before' => 'ajax', 'uses' => 'ServerController@getServers']);
		Route::post('add', ['before' => 'ajax|permissions:servers.add', 'uses' => 'ServerController@add']);
		Route::post('add/search', ['before' => 'ajax|permissions:servers.add', 'uses' => 'ServerController@searchServer']);
		Route::post('add/validate', ['before' => 'ajax|permissions:servers.add', 'uses' => 'ServerController@validateServerPassword']);
		Route::post('delete', ['before' => 'ajax|permissions:servers.delete', 'uses' => 'ServerController@delete']);
		Route::post('players/{id}', ['before' => 'ajax', 'uses' => 'ServerController@getServerPlayers']);
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
			Route::get('/', ['as' => 'settings.users', 'before' => 'permissions:settings.users', 'uses' => 'SettingController@getUsersView']);
			Route::post('/', ['before' => 'ajax|permissions:settings.users', 'uses' => 'UserController@get']);
			Route::post('delete', ['before' => 'ajax|permissions:settings.users.delete', 'uses' => 'UserController@delete']);
			Route::post('edit', ['before' => 'ajax|permissions:settings.users.edit', 'uses' => 'UserController@edit']);
			Route::post('add', ['before' => 'ajax|permissions:settings.users.add', 'uses' => 'UserController@add']);
			Route::post('add/search', ['before' => 'ajax|permissions:settings.users.add', 'uses' => 'UserController@search']);
			Route::post('refresh/{id?}', ['before' => 'ajax|permissions:settings.users.refresh', 'uses' => 'UserController@refresh']);
		});

		Route::group(['prefix' => 'options', 'before' => 'permissions:settings.options'], function()
		{
			Route::get('/', ['as' => 'settings.options', 'uses' => 'SettingController@getOptionsView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'OptionController@get']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'OptionController@edit']);
		});

		Route::group(['prefix' => 'page-management', 'before' => 'permissions:settings.page_management'], function()
		{
			Route::get('/', ['as' => 'settings.page-management', 'uses' => 'SettingController@getPageManagementView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'PageController@get']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'PageController@edit']);
		});

		Route::group(['prefix' => 'permission-control', 'before' => 'permissions:settings.permission_control'], function()
		{
			Route::get('/', ['as' => 'settings.permission-control', 'uses' => 'SettingController@getPermissionControlView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'PermissionController@get']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'PermissionController@edit']);
		});

		Route::group(['prefix' => 'quick-links', 'before' => 'permissions:settings.permission_control'], function()
		{
			Route::get('/', ['as' => 'settings.quick-links', 'uses' => 'SettingController@getQuickLinksView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'QuickLinkController@get']);
			Route::post('delete', ['before' => 'ajax', 'uses' => 'QuickLinkController@delete']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'QuickLinkController@edit']);
			Route::post('add', ['before' => 'ajax', 'uses' => 'QuickLinkController@add']);
		});

		Route::group(['prefix' => 'notifications', 'before' => 'permissions:settings.notifications'], function()
		{
			Route::get('/', ['as' => 'settings.notifications', 'uses' => 'SettingController@getNotificationsView']);
			Route::post('/', ['before' => 'ajax', 'uses' => 'NotificationController@get']);
			Route::post('edit', ['before' => 'ajax', 'uses' => 'NotificationController@edit']);
			Route::post('events', ['before' => 'ajax', 'uses' => 'NotificationController@getEvents']);
			Route::post('event/edit', ['before' => 'ajax', 'uses' => 'NotificationController@editEvent']);
		});
	});

});

/*
|--------------------------------------------------------------------------
| Template Routes
|--------------------------------------------------------------------------
|
| As our templates might be used on secure pages, we don't want the public
| to be able to view them by navigating through the URL. Instead, we load
| the templates via a route with the required permissions/access being 
| validated. This is slower, but more secure.
|
*/

Route::group(['prefix' => 'templates'], function()
{
	Route::get('{name}', ['uses' => 'TemplateController@getTemplate']);
	Route::get('secure/{name}', ['uses' => 'TemplateController@getSecureTemplate']);
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

use Ssms\Services\HipChat\HipChatService;

Route::get('hipchat', function()
{
	Event::fire('user.add', User::find(1));


	// $h = new HipChatService('722203', '69324bc075dd093ed1c57face4d161*');

	// try
	// {
	// 	$h->send('Another test message');
	// }
	// catch(Exception $e)
	// {
	// 	// Log - Something went wrong, log and skip
	// }

});