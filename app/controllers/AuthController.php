<?php

use Ssms\Repositories\User\UserRepository;
use Ssms\Repositories\Role\RoleRepository;

class AuthController extends BaseController {

	/**
	 * @var UserRepositoryInterface
	 */
	protected $users;

	/**
	 * @var RoleRepositoryInterface
	 */
	protected $roles;

	public function __construct(UserRepository $users, RoleRepository $roles)
	{
		$this->users = $users;
		$this->roles = $roles;
	}

	/**
	* Returns an array of user details with a given SteamId object
	*
	* @return array
	*/

	protected function userDetails($steamObject, $enabled = 1)
	{
		$array = [
			'community_id' => $steamObject->getSteamId64(),
			'nickname' => $steamObject->getNickname(),
			'avatar' => $steamObject->getMediumAvatarUrl(),
			'enabled' => $enabled,
		];

		return $array;
	}

	/**
	* Validates an incoming response from Steam against the database
	*
	* @return Redirect
	*/

	public function validateSteamLogin()
	{
		$validate = SteamLogin::validate();

		if (is_null($validate))
		{
			throw new Exception(Lang::get('auth.invalidResponse'));
		}
		else
		{
			$steamObject = new SteamId($validate);

			if ($this->users->count() == 0)
			{
				$user = $this->users->add($this->userDetails($steamObject));

				$roles = $this->roles->getAll();

				foreach ($roles as $role)
				{
					$this->users->assignRole($user, $role->id);
				}

				Auth::login($user);

				return Redirect::route('settings')
					->withFlashNotification(Lang::get('auth.firstLogin'))
					->withFlashNotificationLevel('success');
			}
			else
			{
				$user = $this->users->getFirst('community_id', $steamObject->getSteamId64());

				if (is_null($user))
				{
					throw new Exception(Lang::get('auth.noAccess'));
				}
				else
				{
					if ($user->enabled == 0)
					{
						throw new Exception(Lang::get('auth.accountDisabled'));
					}
					else
					{
						$this->users->edit($user->id, $this->userDetails($steamObject));

						Auth::login($user);

						return Redirect::route('dashboard')
							->withFlashNotification(Lang::get('auth.successfulLogin'))
							->withFlashNotificationLevel('success');
					}
				}
			}
		}
	}

	/**
	* Logs the user out of the application
	*
	* @return Redirect
	*/

	public function logout()
	{
		Auth::logout();

		return Redirect::route('dashboard');
	}
}