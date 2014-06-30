<?php

class SettingController extends BaseController {

	protected function getUsers()
	{
		return User::all();
	}

	protected function getOptions()
	{
		return Option::all();
	}

	protected function getQuickLinks()
	{
		
	}

	public function getView()
	{
		return View::make('pages.settings');
	}

}