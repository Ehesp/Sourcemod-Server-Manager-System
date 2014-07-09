<?php namespace Ssms\Authorization;

class Permission {

	protected $permissions = [];

	public function __construct($permissions)
	{
		$this->permissions = $permissions->toArray();
	}

	public function validate($name)
	{
		$access = false;

		foreach ($this->permissions as $permission)
		{
			if ($permission['name'] == $name)
			{
				$access = true;
				break;
			}
		}

		return $access;		
	}
	
}