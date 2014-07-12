<?php

class SettingController extends BaseController {

	/**
	* Get all users with roles
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
	* @return json
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

			return $this->jsonResponse(200, true, 'User has been successfully been deleted!');
		}
	}

	/**
	* Edit a user
	*
	* Takes a AJAX post request with JSON parameter.
	* @return json
	*/
	public function editUser()
	{
		$user = Input::all();

		// Check if user is trying to disable their own account
		if ($user['id'] == Auth::user()->id && $user['edit']['state'] == 0)
		{
			return $this->jsonResponse(400, false, 'You cannot disable your own account.');
		}

		try
		{
			$update = User::find($user['id']);

			$update->enabled = $user['edit']['state'];
			$update->touch();
			$update->save();

			// Remove all roles apart from guest
			$update->removeRoles(
				Role::where('name', '!=', 'guest')->get()
			);

			// Update new roles
			foreach ($user['edit']['role'] as $role) {
				$update->assignRoles(
					Role::where('id', $role['id'])->get()
				);
			}
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage(), null, $e->getCode());
		}

		return $this->jsonResponse(200, true, 'User has been updated!', User::with('roles')->where('id', $user['id'])->first());

	}

	/**
	* Add a user
	*
	* Takes a AJAX post request with JSON parameters.
	* @return json
	*/
	public function addUser()
	{
		$user = Input::all();

		try
		{
			$create = User::create([
				'community_id' => $user['community_id'],
				'nickname' => $user['nickname'],
				'avatar' => $user['avatar'],
				'enabled' => $user['state'],
			]);

			// Update roles
			if (! is_null($user['role']))
			{
				foreach ($user['role'] as $role)
				{
					$create->assignRoles(
						Role::where('id', $role['id'])->get()
					);
				}

				$create->assignRoles(
					Role::whereName('guest')->get()
				);
			}
			// If no roles chosen, set them as guest
			else
			{
				$create->assignRoles(
					Role::whereName('guest')->get()
				);
			}
		}
		catch (Exception $e)
		{
			// 23000: Integrity constraint violation = Duplicate Entry
			if ($e->getCode() == '23000') return $this->jsonResponse(400, false, 'User already exists!');

			return $this->jsonResponse(400, false, $e->getMessage(), null, $e->getCode());
		}

		return $this->jsonResponse(200, true, 'User has been successfully been added!', User::with('roles')->where('id', $create['id'])->first());
	}

	/**
	* Search for a Steam user via Steam Condenser
	*
	* Takes a AJAX post request with Steam ID parameter.
	* @return json
	*/
	public function userSearch()
	{
		$id = Input::all()[0];

		// If the id is not fully numeric, assume it's a Steam ID, and convert it to a Community ID
		if (! is_numeric($id))
		{
			try
			{
				$id = SteamId::convertSteamIdToCommunityId($id);
			}
			catch (Exception $e)
			{
				return $this->jsonResponse(400, false, $e->getMessage());
			}
		}

		// Grab user details from Steam
		try
		{
			$steamObject = new SteamId($id);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}
		
		return $this->jsonResponse(200, true, 'User profile found!',
			[
				'community_id' => $steamObject->getSteamId64(),
				'nickname' => $steamObject->getNickname(),
				'avatar' => $steamObject->getMediumAvatarUrl(),
			]);
	}

	public function refreshUser($id = null)
	{
		if (! is_null($id))
		{
			$user = Input::all();

			try
			{
				$steamObject = new SteamId($user['community_id']);

				$update = User::find($user['id']);

				$update->nickname = $steamObject->getNickname();
				$update->avatar = $steamObject->getMediumAvatarUrl();
				$update->touch();
				$update->save();
			}
			catch (Exception $e)
			{
				return $this->jsonResponse(400, false, $e->getMessage());
			}

			return $this->jsonResponse(200, true, 'User details refreshed!', User::with('roles')->where('id', $user['id'])->first());
		}
		else
		{
			$users = User::all();

			try
			{
				foreach ($users as $user)
				{
					$steamObject = new SteamId($user['community_id']);
					
					$update = User::find($user['id']);

					$update->nickname = $steamObject->getNickname();
					$update->avatar = $steamObject->getMediumAvatarUrl();
					$update->touch();
					$update->save();
				}
			}
			catch (Exception $e)
			{
				return $this->jsonResponse(400, false, $e->getMessage());
			}

			return $this->jsonResponse(200, true, 'The users have been updated!', User::with('roles')->get());
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

	/**
	* Return the users settings view
	*
	* @return View
	*/
	public function getUsersView()
	{
		return View::make('pages.settings.users');
	}

}