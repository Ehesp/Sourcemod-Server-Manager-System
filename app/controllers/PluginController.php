<?php

class PluginController extends BaseController {

	public function getView()
	{
		return View::make('pages.active-plugins');
	}

}