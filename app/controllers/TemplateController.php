<?php

class TemplateController extends BaseController {

	public function __construct()
	{
		$this->path = app_path() . '/views/templates/';
	}

	public function getSecureTemplate($name)
	{
		if (Permissions::validate($name))
		{
			return File::get($this->path . 'secure/' . $name . '.php');
		}

		return App::abort(404);
	}

	public function getTemplate($name)
	{
		return File::get($this->path . $name . '.php');
	}
}