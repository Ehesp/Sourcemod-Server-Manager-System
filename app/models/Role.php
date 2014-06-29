<?php

class Role extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'roles';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'friendly_name'];

	/**
	* Attach role table to many-to-many relationship with "users" table via the "role_user" pivot table.
	*
	*/
	public function users()
	{
		return $this->belongsToMany('User', 'role_user')->withTimestamps();
	}

	/**
	* Attach role table to many-to-many relationship with "pages" table via the "page_role" pivot table.
	*
	*/
	public function pages()
	{
		return $this->belongsToMany('Page', 'page_role')->withTimestamps();
	}


	/**
	* Return value based on whether the current user has a role, based on their community ID
	*
	* @var bool
	*/
	public function hasUser($community_id)
	{
		foreach ($this->users as $user)
		{
			if($user->community_id == $community_id) return true;
		}

		return false;
	}
}