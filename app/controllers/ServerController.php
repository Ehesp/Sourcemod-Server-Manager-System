<?php

use Ssms\Repositories\Server\ServerRepository;
use Ssms\Repositories\Option\OptionRepository;
use Ssms\Steam\Server;

class ServerController extends BaseController {

	protected $servers;

	protected $options;

	public function __construct(ServerRepository $servers, OptionRepository $options)
	{
		$this->servers = $servers;
		$this->options = $options;
	}

	/**
	* Get all servers
	*
	* @return json
	*/
	public function getServers()
	{
		return $this->servers->getAll();
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
			'options' => $this->options->companionScript(),
		];

		return $this->jsonResponse(200, true, 'Server has been found!', $payload);
	}

	/**
	* Add a server and its details to the database
	*
	* Takes a AJAX post request with JSON parameters
	* @return json
	*/
	public function add()
	{
		$data = Input::all();

		$duplicate = $this->servers->hasDuplicate($data['ip'], $data['port']);

		if (! is_null($duplicate))
		{
			return $this->jsonResponse(400, false, 'Sever ' . $data['ip'] . ':' . $data['port'] . ' already exists!');
		}

		try
		{
			$server = [
				'name' => $data['serverName'],
				'client_appid' => $data['appId'],
				'ip' => $data['ip'],
				'port' => $data['port'],
				'tags' => $data['serverTags'],
				'rcon_password' => $data['rcon'],
				'multi_console' => $data['multiConsole'],
				'operating_system' => $data['operatingSystem'],
				'version' => $data['gameVersion'],
				'network' => $data['networkVersion'],
				'current_map' => $data['mapName'],
				'current_players' => $data['numberOfPlayers'],
				'current_bots' => $data['botNumber'],
				'max_players' => $data['maxPlayers'],
				'auto_update' => $data['autoUpdate'],
				'hidden' => $data['hidden'],
				'daily_restart' => $data['dailyRestart'],
			];

			if ($data['dailyRestart'] == 1)
			{
				$server['daily_restart_time'] = $data['restartTime'];
				$server['daily_restart_commands'] = $data['restartCommands'];
			}

			$server = $this->servers->add($server);
		} 
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage(), null, $e->getCode());
		}

		return $this->jsonResponse(200, true, 'Server successfully added!', $server);
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
		$server = $this->servers->getServerDetails($id);

		$s = new Server($server['ip'], $server['port'], $server['rcon_password']);

		return $s->players();
	}

	public function delete()
	{
		$id = Input::all()[0];

		$this->servers->delete($id);

		return $this->jsonResponse(200, true, 'Server has been deleted!');
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