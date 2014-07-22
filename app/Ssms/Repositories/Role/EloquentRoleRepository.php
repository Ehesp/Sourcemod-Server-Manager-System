<?php namespace Ssms\Repositories\Role;

use Ssms\Repositories\EloquentRepository;
use Role;

class EloquentRoleRepository extends EloquentRepository implements RoleRepositoryInterface {

	/**
	 * @var app/models/Role
	 */
	protected $model;

	public function __construct(Role $model)
	{
		$this->model = $model;
	}
}