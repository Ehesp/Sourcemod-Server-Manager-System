<?php

class TemplateController extends BaseController {

	/**
	 * Construct the template path
	 * @return type
	 */
	public function __construct()
	{
		$this->path = app_path() . '/views/templates/';
	}

	/**
	 * Return a secure template
	 * @param string $name Name of the template/permission
	 * @return mixed
	 */
	public function getSecureTemplate($name)
	{
		if (Permissions::validate($name))
		{
			return File::get($this->path . 'secure/' . $name . '.php');
		}

		return App::abort(404);
	}

	/**
	 * Get an unsecure template
	 * 
	 * @param string $name Template name
	 * @return File
	 */
	public function getTemplate($name)
	{
		return File::get($this->path . $name . '.php');
	}
}