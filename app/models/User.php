<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('remember_token');

	/**
	* The guarded table columns.
	*
	* @var array
	*/
	protected $guarded = array('id');

	/**
	* Attach user table to many-to-many relationship with "Roles" table via the "role_user" pivot table.
	*
	*/
	public function roles()
	{
		return $this->belongsToMany('Role', 'role_user')->withTimestamps();
	}

	/**
	* Return value based on whether the current user has a role.
	*
	* @var bool
	*/
	public function hasRole($name)
	{
		foreach ($this->roles as $role)
		{
			if($role->name == $name) return true;
		}

		return false;
	}

	/**
	* Assign a user a role by ID or Object
	*
	*/
	public function assignRole($role)
	{
		$this->roles()->attach($role);
	}

	/**
	* Remove the users role by ID or Object
	*
	*/
	public function removeRole($role)
	{
		$this->roles()->detach($role);
	}
}
