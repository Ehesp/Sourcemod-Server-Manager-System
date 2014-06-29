<?php

class AuthController extends BaseController {

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
		$validate = Ssms\Steam\Login::validate();

		if (is_null($validate))
		{
			throw new Exception(Lang::get('auth.invalidResponse'));
		}
		else
		{
			$steamObject = new SteamId($validate);

			if (User::count() == 0)
			{
				$user = User::create(
					$this->userDetails($steamObject)
				);

				$user->assignRoles(
					Role::get()
				);

				Auth::login($user);

				return Redirect::to('settings')
					->withFlashNotification(Lang::get('auth.firstLogin'))
					->withFlashNotificationLevel('success');
			}
			else
			{
				$user = User::where('community_id', $steamObject->getSteamId64())->first();

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
						User::find($user->id)->update(
							$this->userDetails($steamObject)
						);

						Auth::login($user);

						return Redirect::to('/')
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