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

	public function deleteUser()
	{
		$id = Input::all()[0];

		if (User::count() == 1)
		{
			return App::abort(405,'You are the only user in the application and cannot be deleted!');
		}
		else if (Auth::user()->id == $id)
		{
			return App::abort(405,'You can not delete yourself!');
		}
		else
		{
			try
			{
				User::destroy($id);
			}
			catch (Exception $e)
			{
				return App::abort(405,'An error occured: ' . $e->getMessage());
			}

			return Response::json(['message' => 'The user has successfully been deleted!']);
		}
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