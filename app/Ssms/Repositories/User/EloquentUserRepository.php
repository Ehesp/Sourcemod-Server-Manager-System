<?php namespace Ssms\Repositories\User;

use User;

class EloquentUserRepository implements UserRepositoryInterface {

	public function getAll()
	{
		return User::all();
	}

	public function getWithRoles($id = null)
	{
		if (! is_null($id))
		{
			return User::find($id)->with('roles')->first();
		}

		return User::with('roles')->get();
	}

	public function delete($id)
	{
		User::destroy($id);
	}

}