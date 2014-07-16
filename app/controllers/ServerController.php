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
			$server['ip'] = gethostbyname($server['ip']);

			$s = new Server($server['ip'], $server['port']);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, 'Unable to find server on ' . $server['ip'] . ':' . $server['port'] .' - Error: ' . $e->getMessage());
		}

		try
		{
			$s->validateRconPass($server['rcon']);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, 'Invalid RCON password or server is blocking your IP address.');
		}

		$payload = [
			'server' => $s->info(),
			'options' => Option::whereName('companion_script')->get(['name', 'value'])
		];

		return $this->jsonResponse(200, true, 'Server has been found!', $payload);
	}

	/**
	* Add a server and its details to the database
	*
	* Takes a AJAX post request with JSON parameters
	* @return json
	*/
	public function addServer()
	{
		$server = Input::all();

		$duplicate = Ssms\Server::where('ip', $server['ip'])->where('port', $server['port'])->first();

		if (! is_null($duplicate))
		{
			return $this->jsonResponse(400, false, 'Sever ' . $server['ip'] . ':' . $server['port'] . ' already exists!');
		}

		try
		{
			$s = new Ssms\Server;

			$s->name = $server['serverName'];
			$s->client_appid = $server['appId'];
			$s->ip = $server['ip'];
			$s->port = $server['port'];
			$s->tags = $server['serverTags'];
			$s->rcon_password = $server['rcon'];
			$s->multi_console = $server['multiConsole'];
			$s->operating_system = $server['operatingSystem'];
			$s->version = $server['gameVersion'];
			$s->network = $server['networkVersion'];
			$s->current_map = $server['mapName'];
			$s->current_players = $server['numberOfPlayers'];
			$s->current_bots = $server['botNumber'];
			$s->max_players = $server['maxPlayers'];
			$s->auto_update = $server['autoUpdate'];
			$s->hidden = $server['hidden'];
			$s->daily_restart = $server['dailyRestart'];
			
			if ($server['dailyRestart'] == 1)
			{
				$s->daily_restart_time = $server['restartTime'];
				$s->daily_restart_commands = $server['restartCommands'];
			}

			$s->save();
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage(), null, $e->getCode());
		}

		return $this->jsonResponse(200, true, 'Server successfully added!', $s);
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
	* Returns the players on a server by ID
	*
	* Takes a AJAX post request
	* @return json
	*/
	public function getServerPlayers($id)
	{
		$server = Ssms\Server::where('id', $id)->first(['ip', 'port', 'rcon_password']);

		$s = new Server($server['ip'], $server['port'], $server['rcon_password']);

		return $s->players();
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