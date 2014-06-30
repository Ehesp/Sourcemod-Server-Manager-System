<?php

class ConsoleController extends BaseController {

	public function getView()
	{
		return View::make('pages.multi-console');
	}

}