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
			throw new Exception("The response from Steam was invalid");
		}
		else
		{
			$steamObject = new SteamId($validate);

			if (User::count() == 0)
			{
				$user = User::create(
					$this->userDetails($steamObject)
				);

				Auth::login($user);

				return Redirect::to('/');
			}
			else
			{
				$user = User::where('community_id', $steamObject->getSteamId64())->first();

				if (is_null($user))
				{
					throw new Exception("Steam user doesn't have access");
				}
				else
				{
					if ($user->enabled == 0)
					{
						throw new Exception("Steam user has their access disabled");
					}
					else
					{
						User::find($user->id)->update(
							$this->userDetails($steamObject)
						);

						Auth::login($user);

						return Redirect::to('/');
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

		return Redirect::to('/');
	}
}