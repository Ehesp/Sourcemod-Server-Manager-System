<?php namespace Ssms\Repositories\Permission;

interface PermissionRepositoryInterface {

	public function getWithRolesPage($id);

	public function removeRole($permission, $role);
	
	public function assignRole($permission, $role);

}