<?php

class DashboardController extends BaseController {

	public function getView()
	{
		return View::make('pages.dashboard');
	}

}
