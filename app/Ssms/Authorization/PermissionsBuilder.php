<?php namespace Ssms\Authorization;

use Role;

class PermissionsBuilder {

	/**
	 * The $app->auth instance
	 *
	 */
	protected $auth;

	/**
	 * Create a new PermissionBuilder instance.
	 *
	 * @return void
	 */
	public function __construct($auth)
	{
		$this->auth = $auth;
		$this->permissions = $this->getUserPermissions();
	}

	/**
	 * Returns the permissions which are accessible to the user in their
	 * current authenticated state.
	 * 
	 * @return json
	 */
	private function getUserPermissions()
	{
		if ($this->auth->guest())
		{
			return Role::whereName('guest')->first()->permissions;
		}
		else
		{
			return $this->auth->user()->permissions;
		}
	}

	/**
	 * Determins whether the user has permission for the 
	 * given value.
	 * 
	 * @return bool
	 */
	public function validate($value, $type = 'name')
	{
		$access = false;

		foreach ($this->permissions as $permission)
		{
			if ($permission->$type == $value)
			{
				$access = true;
				break;
			}
		}

		return $access;		
	}

	/**
	 * Returns the permissions the user is able to access
	 * 
	 * @return json
	 */
	public function permissions()
	{
		return $this->permissions;
	}
}