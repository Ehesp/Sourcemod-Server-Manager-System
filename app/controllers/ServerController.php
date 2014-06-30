<?php

class ServerController extends BaseController {

	public function getView()
	{
		return View::make('pages.servers');
	}

}