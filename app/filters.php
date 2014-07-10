<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	/**
	* When user is not logged in
	*
	*/

	if (Auth::guest())
	{
		// Share the steam login URL with the view
		View::share('steamLoginUrl',
			Ssms\Steam\Login::genUrl(
				Config::get('steam.returnTo'), true
			)
		);
	}

	/**
	* When any user visits
	*
	*/

	View::share('pages',
		Access::pages()
	);

	// Share the quick links with the views
	View::share('quickLinks',
		QuickLink::get([
			'name', 'url', 'icon'
		])
	);

	// Attach some PHP variables to the "ssms" JavaScript scope
	JavaScript::put([
		'app_path' => URL::to('/') . '/',
		'template_path' => URL::to('templates') . '/',
	]);

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Access Filter
|--------------------------------------------------------------------------
|
*/

Route::filter('access', function()
{
	if(! Access::validate(Request::segment(1))) return App::abort(401, 'You do not have the required access for this page');
});

/*
|--------------------------------------------------------------------------
| Permission Filter
|--------------------------------------------------------------------------
|
*/

Route::filter('permission', function($route, $request, $value)
{
	if(! Permission::validate($value)) return App::abort(401, 'Insufficient permissions');
});

/*
|--------------------------------------------------------------------------
| Auth Filters
|--------------------------------------------------------------------------
|
*/

Route::filter('auth', function()
{
	if (! Auth::check()) return App::abort(401, 'Authentication required');
});

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
