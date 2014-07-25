<?php namespace Ssms\Repositories\Permission;

use Ssms\Repositories\EloquentRepository;
use Permission;

class EloquentPermissionRepository extends EloquentRepository implements PermissionRepository {

		/**
	 * @var app/models/Permission
	 */
	protected $model;

	public function __construct(Permission $model)
	{
		$this->model = $model;
	}

	public function getWithRolesPage($id = null)
	{
		if (! is_null($id))
		{
			return $this->model->with('roles', 'page')->find($id);
		}

		return $this->model->with('roles', 'page')->get();
	}

	public function removeRole($permission, $role)
	{
		$permission->roles()->detach($role);
	}

	public function assignRole($permission, $role)
	{
		$permission->roles()->attach($role);
	}

}