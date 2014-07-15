<?php

use Ssms\Steam\Server;

class ServerController extends BaseController {

	/**
	* Get all servers
	*
	* @return json
	*/
	public function getServers()
	{
		return Ssms\Server::all();
	}
	
	/**
	* Search for a server and return its info if successful
	*
	* Takes a AJAX post request with JSON parameters
	* @return json
	*/
	public function searchServer()
	{
		$server = Input::all();

		try
		{
			$s = new Server($server['ip'], $server['port']);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, 'Could not find server ' . $server['ip'] . ':' . $server['port'] .' - ' . $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Server has been found!', $s->info());
	}

	/**
	* Add a server and its details to the database
	*
	* Takes a AJAX post request with JSON parameters
	* @return json
	*/
	public function addServer()
	{
		// $server = Input::all();

		// $s = new Server($server['ip'], $server['port']);

		// if (! $s->validateRconPass($server['rcon']))
		// {
		// 	return $this->jsonResponse(400, false, 'Invalid RCON password!');
		// }
		// else
		// {
		// 	$info = $s->info();

		// 	try
		// 	{
		// 		Ssms\Server::create([
		// 			'name' => $info['serverName'],
		// 			'ip' => $server['ip'],
		// 			'port' => $server['port'],
		// 			'tags' => $info['serverTags'],
		// 			'rcon_password' => Hash::make($server['rcon']),
		// 			'multi_console' => $server['multi_console'],
		// 			'game_type' => $info['operatingSystem'],
		// 			'version' => $info['gameVersion'],
		// 			'network' => $info['networkVersion'],
		// 			'network' => $info['networkVersion'],
		// 		]);
		// 	}
		// 	catch (Exception $e)
		// 	{
		// 		return $this->jsonResponse(400, false, 'Failed to add server: ' . $e->getMessage());
		// 	}
		// }
	}

	/**
	* Validate a given server RCON password
	*
	* Takes a AJAX post request with JSON parameters
	* @return json
	*/
	public function validateServerPassword()
	{
		$server = Input::all();

		$s = new Server($server['ip'], $server['port']);

		try
		{
			$s->validateRconPass($server['rcon']);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, 'Invalid RCON password!');
		}

		return $this->jsonResponse(200, true, 'RCON Password successfully validated!');
	}

	/**
	* Return the servers page view
	*
	* @return View
	*/
	public function getView()
	{
		return View::make('pages.servers');
	}

}