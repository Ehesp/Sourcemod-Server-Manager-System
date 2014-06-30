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
	* Assign a user multiple roles by Object
	*
	*/
	public function assignRoles($roles)
	{
		foreach ($roles as $role) {
			$this->roles()->attach($role);
		}
	}

	/**
	* Remove the users role by ID or Object
	*
	*/
	public function removeRole($role)
	{
		$this->roles()->detach($role);
	}

	/**
	* The 'pages' accessor
	*
	*/
	public function getPagesAttribute()
	{
	    if ( ! array_key_exists('pages', $this->relations)) $this->loadPages();

	    return $this->getRelation('pages');
	}

	/**
	* Load pages user is allowed to access and set the collection as 'pages' relation
	*
	*/
	protected function loadPages()
	{
	    $pages = Page::join('page_role as pr', 'pr.page_id', '=', 'pages.id')
	           ->join('role_user as ru', 'ru.role_id', '=', 'pr.role_id')
	           ->where('ru.user_id', $this->id)
	           ->distinct()
	           ->get(['pages.*', 'user_id']);

	    $hasMany = new Illuminate\Database\Eloquent\Relations\HasMany(Page::query(), $this, 'user_id', 'id');

	    $hasMany->matchMany([$this], $pages, 'pages');

	    return $this;
	}


	/**
	* The 'permissions' accessor
	*
	*/
	public function getPermissionsAttribute()
	{
	    if ( ! array_key_exists('permissions', $this->relations)) $this->loadPermissions();

	    return $this->getRelation('permissions');
	}

	/**
	* Load pages user is allowed to access and set the collection as 'pages' relation
	*
	*/
	protected function loadPermissions()
	{
	    $permissions = Permission::join('permission_role as pr', 'pr.permission_id', '=', 'permissions.id')
	           ->join('role_user as ru', 'ru.role_id', '=', 'pr.role_id')
	           ->where('ru.user_id', $this->id)
	           ->distinct()
	           ->get(['permissions.*', 'user_id']);

	    $hasMany = new Illuminate\Database\Eloquent\Relations\HasMany(Page::query(), $this, 'user_id', 'id');

	    $hasMany->matchMany([$this], $permissions, 'permissions');

	    return $this;
	}
}
