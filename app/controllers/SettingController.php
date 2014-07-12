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

	/**
	* Refresh a user, or all users
	*
	* Takes a AJAX post request.
	* @return json
	*/
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
	* Get all options
	*
	* @return json
	*/
	public function getOptions()
	{
		return Option::all();
	}

	/**
	* Update an option
	*
	* Takes a AJAX post request.
	* @return json
	*/
	public function updateOption()
	{
		$option = Input::all();

		if ($option['value'] === null || $option['value'] == '')
		{
			return $this->jsonResponse(400, false, "The option value must be present!");
		}

		try
		{
			$update = Option::find($option['id']);
			$update->value = $option['value'];
			$update->touch();
			$update->save();
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'The option has been updated!', Option::find($option['id']));
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
	* Get pages and their access
	*
	* @return json
	*/
	protected function getPageManagement()
	{
		return Page::with('roles')->get();
	}

	/**
	* Edit a page
	*
	* Takes a AJAX post request.
	* @return json
	*/
	protected function editPage()
	{
		$page = Input::all();

		// If no icon given
		if ($page['edit']['icon'] === null || $page['edit']['icon'] == '') return $this->jsonResponse(400, false, "The icon field cannot be left empty!");

		// If invalid font awesome name 
		if (strpos($page['edit']['icon'], 'fa fa-') !== false)
		{}
		else return $this->jsonResponse(400, false, "The icon name supplied is not a valid Font Awesome icon!");

		// Page must have a role attached
		if (count($page['edit']['role']) == 0) return $this->jsonResponse(400, false, "A page must have at least one role!");

		// Stop user assigning User/Guest role to settings and multi_console page
		if ($page['name'] == 'settings' || $page['name'] == 'multi_console')
		{
			foreach ($page['edit']['role'] as $role)
			{
				if ($role['name'] == 'user' || $role['name'] == 'guest') return $this->jsonResponse(400, false, "Unable to give page User or Guest privilages for security reasons!");
			}
		}

		try
		{
			$update = Page::find($page['id']);

			$update->icon = $page['edit']['icon'];
			$update->touch();
			$update->save();

			// Remove all page roles
			$update->removeRoles(
				Role::all()
			);

			//Give page new set of chosen roles
			foreach ($page['edit']['role'] as $role)
			{
				$update->assignRoles(
					Role::where('name', $role['name'])->get()
				);
			}
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Page successfully updated!', Page::with('roles')->find($page['id']));

	}

	/**
	* Return the master settings overview with data
	*
	* @return View
	*/
	public function getView()
	{
		return View::make('pages.settings')
			->with('users', $this->getUsers())
			->with('options', $this->getOptions())
			->with('page_access', $this->getPageManagement())
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

	/**
	* Return the options settings view
	*
	* @return View
	*/
	public function getOptionsView()
	{
		return View::make('pages.settings.options');
	}

	/**
	* Return the page-access settings view
	*
	* @return View
	*/
	public function getPageManagementView()
	{
		return View::make('pages.settings.page-management');
	}
}