<?php

class AdminController extends BaseController {

	public function getView()
	{
		return View::make('pages.admin-activity');
	}

}