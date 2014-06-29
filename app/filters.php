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
		$pages = Role::whereName('guest')->first()->pages;

		App::instance('pages', $pages);

		View::share('sidebarPages',
			$pages
		);

		View::share('steamLoginUrl',
			Ssms\Steam\Login::genUrl(
				Config::get('steam.returnTo'), true
			)
		);
	}

	/**
	* When user is logged in
	*
	*/

	else
	{
		$pages = Auth::user()->pages;

		App::instance('pages', $pages);
	
		View::share('sidebarPages',
			$pages
		);
	}

	/**
	* When any user visits
	*
	*/

	View::share('quickLinks',
		DB::table('quick_links')->get([
			'name', 'url', 'icon'
		])
	);


});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('access', function()
{
	$auth = new Ssms\PageMngt\Access;

	$pages = App::make('pages');

	$auth->checkPageAccess($pages, Request::segment(1));
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

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
