<?php

class AuthController extends BaseController {

	public function validateSteamLogin()
	{
		$validate = Ssms\Steam\Login::validate();

		if (is_null($validate))
		{
			dd("An error occured (null)");
		}

		dd($validate);
	}

}