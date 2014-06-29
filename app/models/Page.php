<?php

class Page extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'pages';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'friendly_name', 'icon', 'slug'];

	/**
	* Attach user table to many-to-many relationship with "Roles" table via the "page_role" pivot table.
	*
	*/
	public function roles()
	{
		return $this->belongsToMany('Role', 'page_role')->withTimestamps();
	}

	/**
	* Assign a page a role by ID or Object
	*
	*/
	public function assignRole($role)
	{
		$this->roles()->attach($role);
	}

	/**
	* Assign a page multiple roles by object
	*
	*/
	public function assignRoles($roles)
	{
		foreach ($roles as $role) {
			$this->roles()->attach($role);
		}
	}

	/**
	* Remove the page role by ID or Object
	*
	*/
	public function removeRole($role)
	{
		$this->roles()->detach($role);
	}
}