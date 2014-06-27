<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('pages.dashboard');

	/* Attach user to a certain role */
	// User::find(Auth::user()->id)->roles()->attach(1);

	/* Attach user to a role, method way */
	// $user = User::find(Auth::user()->id);
	// $user->assignRole($role) - ID/Object

	/* Get user with their roles */
	// User::with('roles')->find(Auth::user()->id);

	/* Get user roles only */
	// User::find(Auth::user()->id)->roles;

	/* Get user roles first name only */
	// User::find(Auth::user()->id)->roles->first()->name;

	/* Does a user have a certain role? (by name) */
	// $user = User::find(Auth::user()->id);
	// if($user->hasRole('super_admin')) return "yep";

	



	//return User::with('roles')->find(Auth::user()->id);

});

Route::get('settings', ['as' => 'settings', 'uses' => 'SettingController@getView']);

Route::get('login', 'AuthController@validateSteamLogin');

Route::get('logout', 'AuthController@logout');
