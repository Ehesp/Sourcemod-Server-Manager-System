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
	* Delete a user
	*
	* Takes a AJAX post request with an ID parameter.
	*/

	public function deleteUser()
	{
		$id = Input::all()[0];

		if (User::count() == 1)
		{
			return $this->jsonResponse(400, false, 'You are the only user left in the application and cannot delete youself.');
		}
		else if (Auth::user()->id == $id)
		{
			return $this->jsonResponse(400, false, 'You are unable to delete yourself from the application.');
		}
		else
		{
			User::destroy($id);

			return $this->jsonResponse(200, true, 'User has been successfully been deleted!.');
		}
	}

	public function userSearch()
	{
		// $string = Input::all()[0];

		// $string = '76561197993035972';
		$id = 'STEAM_0:0:16385122ewd';

		if (! is_numeric($id))
		{
			try
			{
				$id = SteamId::convertSteamIdToCommunityId($id);
			}
			catch (Exception $e)
			{
				App::abort(400, $e->getMessage());
			}
		}

		try
		{
			$steam = new SteamId($id);
		}
		catch (Exception $e)
		{
			App::abort(400, $e->getMessage());
		}
		
		dd($steam);
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