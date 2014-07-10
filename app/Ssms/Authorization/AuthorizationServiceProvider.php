<?php namespace Ssms\Authorization;

use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerAccessBuilder();
		$this->registerPermissionBuilder();
	}

	/**
	 * Register the Access builder instance.
	 *
	 * @return void
	 */
	protected function registerAccessBuilder()
	{
		$this->app->bindShared('access', function($app)
		{
			return new AccessBuilder($app['auth']);
		});
	}

	/**
	 * Register the Permission builder instance.
	 *
	 * @return void
	 */
	protected function registerPermissionBuilder()
	{
		$this->app->bindShared('permission', function($app)
		{
			return new PermissionBuilder($app['auth']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('access', 'permission');
	}

}