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
	* Share the pages the user is able to access to the views under 
	* the $pages variable.
	*
	*/

	View::share('pages',
		Access::pages()
	);

	/**
	* Share the quick links with the views using the
	* the $quickLinks variable.
	*
	*/

	View::share('quickLinks',
		QuickLink::get([
			'name', 'url', 'icon'
		])
	);

	/**
	* Share the site options with the views under
	* the $siteOptions variable.
	*
	*/

	$options = Option::get(['name', 'value']);

	foreach ($options as $option)
		$o[$option->name] = $option->value;

	View::share('siteOptions', $o);

	/**
	* Attach a PHP array to the window to allow JavaScript to use.
	* The "URL" provider is used rather than the Laravel helper paths
	* to ensure the paths are consistent across Windows and Unix platforms.
	*
	* @see https://github.com/laracasts/PHP-Vars-To-Js-Transformer
	*/

	JavaScript::put([
		'app_path' => URL::to('/') . '/',
		'roles' => Role::get(['id', 'friendly_name']),
		'services' => Service::get(['id', 'friendly_name']),
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
	if(! Access::validate(Request::segment(1))) return App::abort(403, 'You do not have the required access for this page');
});

/*
|--------------------------------------------------------------------------
| Permissions Filter
|--------------------------------------------------------------------------
|
*/

Route::filter('permissions', function($route, $request, $value)
{
	if(! Permissions::validate($value)) return App::abort(403, 'Insufficient permissions');
});

/*
|--------------------------------------------------------------------------
| Ajax Filter
|--------------------------------------------------------------------------
|
*/

Route::filter('ajax', function()
{
	if (! Request::ajax()) return App::abort(406, 'The request to this resource must be via Ajax');
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
