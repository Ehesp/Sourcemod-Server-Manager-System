<?php namespace Ssms\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ssms\Authorization\AccessBuilder
 */
class Permissions extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'permissions'; }

}