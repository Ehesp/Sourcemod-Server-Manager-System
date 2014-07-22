<?php

use Ssms\Repositories\User\UserRepositoryInterface;
use Ssms\Repositories\Role\RoleRepositoryInterface;

class UserController extends BaseController {

	protected $users;

	protected $roles;

	public function __construct(UserRepositoryInterface $users, RoleRepositoryInterface $roles)
	{
		$this->users = $users;
		$this->roles = $roles;
	}

	public function getUsers()
	{
		return $this->users->getWithRoles();
	}

	public function addUser()
	{
		$data = Input::all();

		$add = [
			'community_id' => $data['community_id'],
			'nickname' => $data['nickname'],
			'avatar' => $data['avatar'],
			'enabled' => $data['state'],
		];

		try 
		{
			$user = $this->users->add($add);
		}
		catch (Exception $e)
		{
			// 23000: Integrity constraint violation = Duplicate Entry
			if ($e->getCode() == '23000') return $this->jsonResponse(400, false, 'User already exists!');

			return $this->jsonResponse(400, false, $e->getMessage(), null, $e->getCode());
		}

		$guest = $this->roles->getFirst('name', 'guest');

		if (! is_null($data['role']))
		{
			foreach ($data['role'] as $role)
			{
				$this->users->assignRole($user, $role['id']);
			}

			$this->users->assignRole($user, $guest['id']);
		}
		else
		{
			$this->users->assignRole($user, $guest['id']);
		}

		return $this->jsonResponse(200, true, 'User has been successfully been added!', $this->users->getWithRoles($user['id']));
	}

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
		
		return $this->jsonResponse(200, true, 'User profile found!', [
			'community_id' => $steamObject->getSteamId64(),
			'nickname' => $steamObject->getNickname(),
			'avatar' => $steamObject->getMediumAvatarUrl(),
		]);
	}

	public function refreshUser($id = null)
	{
		if (! is_null($id))
		{
			$data = Input::all();

			try
			{
				$steamObject = new SteamId($data['community_id']);

				$update = [
					'nickname' => $steamObject->getNickname(),
					'avatar' =>  $steamObject->getMediumAvatarUrl()
				];

				$this->users->edit($data['id'], $update);
			}
			catch (Exception $e)
			{
				return $this->jsonResponse(400, false, $e->getMessage());
			}

			return $this->jsonResponse(200, true, 'User details refreshed!', $this->users->getWithRoles($data['id']));
		}
		else
		{
			$users = $this->users->getAll();

			try
			{
				foreach ($users as $user)
				{
					$steamObject = new SteamId($user['community_id']);
					
					$update = [
						'nickname' => $steamObject->getNickname(),
						'avatar' => $steamObject->getMediumAvatarUrl(),
					];

					$this->users->edit($user['id'], $update);
				}
			}
			catch (Exception $e)
			{
				return $this->jsonResponse(400, false, $e->getMessage());
			}

			return $this->jsonResponse(200, true, 'The users have been updated!', $this->users->getWithRoles());
		}
	}

	public function deleteUser()
	{
		$id = Input::all()[0];

		if ($this->users->count() == 1)
		{
			return $this->jsonResponse(400, false, 'You are the only user left in the application and cannot delete youself.');
		}
		else if (Auth::user()->id == $id)
		{
			return $this->jsonResponse(400, false, 'You are unable to delete yourself from the application.');
		}
		else
		{
			$this->users->delete($id);

			return $this->jsonResponse(200, true, 'User has been successfully been deleted!');
		}
	}

	public function editUser()
	{
		$data = Input::all();

		// Check if user is trying to disable their own account
		if ($data['id'] == Auth::user()->id && $data['edit']['state'] == 0)
			return $this->jsonResponse(400, false, 'You cannot disable your own account.');

		$user = $this->users->edit($data['id'], [
			'enabled' => $data['edit']['state'],
		]);

		$roles = $this->roles->getBy('name', 'guest', '!=');

		foreach ($roles as $role)
		{
			$this->users->removeRole($user, $role);
		}

		foreach ($data['edit']['role'] as $role)
		{
			$this->users->assignRole($user, $role['id']);
		}

		return $this->jsonResponse(200, true, 'Successfully updated the user!', $this->users->getWithRoles($data['id']));
	}

}