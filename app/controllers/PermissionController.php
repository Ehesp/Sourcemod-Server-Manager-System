<?php

use Ssms\Repositories\Permission\PermissionRepositoryInterface;
use Ssms\Repositories\Role\RoleRepositoryInterface;

class PermissionController extends BaseController {

	protected $permissions;

	protected $roles;

	public function __construct(PermissionRepositoryInterface $permissions, RoleRepositoryInterface $roles)
	{
		$this->permissions = $permissions;
		$this->roles = $roles;
	}

	public function editPermission()
	{
		$data = Input::all();

		// Permission must have a role attached
		if (count($data['edit']['role']) == 0) return $this->jsonResponse(400, false, "A permission must have at least one role!");

		// Stop user assigning User/Guest role to servers.rcon and multi_console.execute
		if ($data['name'] == 'multi_console.execute' || $data['name'] == 'servers.rcon')
		{
			foreach ($data['edit']['role'] as $role)
			{
				if ($role['name'] == 'user' || $role['name'] == 'guest') return $this->jsonResponse(400, false, "Unable to give permissions to User or Guest for security reasons!");
			}
		}

		try
		{
			$permission = $this->permissions->getFirst('id', $data['id']);

			$roles = $this->roles->getAll();

			foreach ($roles as $role)
			{
				$this->permissions->removeRole($permission, $role['id']);
			}

			//Give page new set of chosen roles
			foreach ($data['edit']['role'] as $role)
			{
				$this->permissions->assignRole($permission, $role['id']);
			}
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Permission has successfully been updated!', $this->permissions->getWithRolesPage($data['id']));
	}

	
}