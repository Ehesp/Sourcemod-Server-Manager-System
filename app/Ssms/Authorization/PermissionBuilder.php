<?php namespace Ssms\Authorization;

use Role;

class PermissionBuilder {

	protected $auth;

	public function __construct($auth)
	{
		$this->auth = $auth;
		$this->permissions = $this->getUserPermissions();
	}

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
	
}