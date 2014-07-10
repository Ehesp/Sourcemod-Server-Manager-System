<?php

class SettingController extends BaseController {

	/**
	* Get all users
	*
	* @return json
	*/

	public function getUsers()
	{
		return User::with('roles')->get();
	}

	/**
	* Get a limited number of users
	*
	* @return json
	*/

	protected function limitUsers($n = 5)
	{
		return User::take($n)->get();
	}

	/**
	* Return a response of users with pagination
	*
	* @return json
	*/

	protected function paginateUsers($n = 20)
	{
		return User::paginate($n);
	}

	/**
	* Get all options
	*
	* @return json
	*/

	protected function getOptions()
	{
		return Option::all();
	}

	/**
	* Get a limited number of options
	*
	* @return json
	*/

	protected function limitOptions($n = 5)
	{
		return Option::take($n)->get();
	}

	/**
	* Get quick links
	*
	* @return json
	*/

	protected function getQuickLinks()
	{
		return QuickLink::all();
	}

	/**
	* Return the master settings overview with data
	*
	* @return View
	*/

	public function getView()
	{
		return View::make('pages.settings')
			->with('users', $this->limitUsers())
			->with('options', $this->limitOptions())
			->with('quick_links', $this->getQuickLinks());
	}

	public function getUsersView()
	{
		return View::make('pages.settings.users');
	}

}