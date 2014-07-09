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
		// Bind guest permissions to the IoC container
		App::instance('permissions', Role::whereName('guest')->first()->permissions);

		// Get pages guest is allowed to access
		$pages = Role::whereName('guest')->first()->pages;

		// Bind pages to the IoC container
		App::instance('pages', $pages);

		// Share the pages with the views
		View::share('sidebarPages',
			$pages
		);

		// Share the steam login URL with the view
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
		// Bind the user permissions to the IoC container
		App::instance('permissions', Auth::user()->permissions);

		// Get pages the user is allowed to access
		$pages = Auth::user()->pages;

		// Bind the pages to the IoC container
		App::instance('pages', $pages);
	
		// Share the pages with the views
		View::share('sidebarPages',
			$pages
		);
	}

	/**
	* When any user visits
	*
	*/

	// Share the quick links with the views
	View::share('quickLinks',
		QuickLink::get([
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
| Access Filter
|--------------------------------------------------------------------------
|
| Checks the current root page with the pages data from the IoC container
| and checks whether the user can access that page.
|
*/

Route::filter('access', function()
{
	$auth = new Ssms\Authorization\Access;

	$pages = App::make('pages');

	$auth->checkPageAccess($pages, Request::segment(1));
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
