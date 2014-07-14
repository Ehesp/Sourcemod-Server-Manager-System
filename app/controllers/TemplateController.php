<?php

class TemplateController extends BaseController {

	public function __construct()
	{
		$this->path = app_path() . '/views/templates/';
	}

	public function getSettingsNewUserTemplate()
	{
		return File::get($this->path . 'settings.new-user.php');
	}

	public function getServersNewServerTemplate()
	{
		return File::get($this->path . 'servers.new-server.php');
	}

}