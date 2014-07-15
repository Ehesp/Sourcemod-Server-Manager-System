<?php

class TemplateController extends BaseController {

	public function __construct()
	{
		$this->path = app_path() . '/views/templates/';
	}

	public function getTemplate($name)
	{
		if (Permissions::validate($name))
		{
			return File::get($this->path . $name . '.php');
		}

		return App::abort(404);
	}
}