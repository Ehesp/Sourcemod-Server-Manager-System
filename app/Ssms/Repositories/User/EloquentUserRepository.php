<?php namespace Ssms\Repositories\User;

use Ssms\Repositories\EloquentRepository;
use User;

class EloquentUserRepository extends EloquentRepository implements UserRepository {

	/**
	 * @var app/models/User
	 */
	protected $model;

	public function __construct(User $model)
	{
		$this->model = $model;
	}

	/**
	 * Returns a JSON object of a user(s) with the attatched roles
	 * 
	 * @param int $id Optional id to return a specific user
	 * @return object
	 */
	public function getWithRoles($id = null)
	{
		if (! is_null($id))
		{
			return $this->model->with('roles')->find($id);
		}

		return $this->model->with('roles')->get();
	}

	/**
	 * Removes a role from a given user
	 *
	 * @param object $user Eloquent object of the user
	 * @param int $role ID of the Role to remove
	 * @return void
	 */
	public function removeRole($user, $role)
	{
		$user->roles()->detach($role);
	}

	/**
	 * Assings a role to a given user
	 *
	 * @param object $user Eloquent object of the user
	 * @param int $role ID of the Role to assign
	 * @return void
	 */
	public function assignRole($user, $role)
	{
		$user->roles()->attach($role);
	}

}