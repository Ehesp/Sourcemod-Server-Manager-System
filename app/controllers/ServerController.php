<?php

use Ssms\Steam\Server;

class ServerController extends BaseController {

	public function getView()
	{
		return View::make('pages.servers');
	}

	public function getServers()
	{
		return Ssms\Server::all();
	}

	public function addServer()
	{
		try
		{
			$s = new Server('46.4.99.5', 37085);
		}
		catch (Exception $e)
		{
			dd($e->getMessage());
		}

		return $s->info();
	}

}