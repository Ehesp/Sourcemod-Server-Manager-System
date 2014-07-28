<?php

class Permission extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'permissions';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'page_id'];
	
	/**
	* Disable timestamps
	*
	* @var boolen
	*/
	public $timestamps = false;

	/**
	* Each permission belongs to a single page (one-to-many).
	*
	*/
	public function page()
	{
		return $this->belongsTo('Page');
	}

	/**
	* Attach user table to many-to-many relationship with "Roles" table via the "page_role" pivot table.
	*
	*/
	public function roles()
	{
		return $this->belongsToMany('Role', 'permission_role')->orderBy('id', 'asc')->withTimestamps();
	}

	public function assignRoles($roles)
	{
		foreach ($roles as $role) {
			$this->roles()->attach($role->id);
		}
	}
}