<?php namespace Ssms\Steam;

use SourceServer;

class Server {

    /**
     * @var string The IP Address of the server
     */
	protected $ip;

    /**
     * @var int The port number of the server
     */
	protected $port;

    /**
     * Creates a new SourceServer instance
     *
     */
	public function __construct($ip, $port)
	{
		$this->server = new SourceServer($ip, $port);
		$this->initialize($this->server);
	}

    /**
     * Initalize the server details
     * Turn off user notices from SteamCondenser
     *
     */
	private function initialize($s)
	{
		error_reporting(E_ALL ^ E_USER_NOTICE);
		$s->initialize();
	}

    /**
     * Return the server instance information 
     *
     */
	public function info()
	{
		return $this->server->getServerInfo();
	}

    /**
     * Return the server instance current players 
     *
     */
	public function players()
	{
		return $this->server->getPlayers();
	}

    /**
     * Return the server instance ping 
     *
     */
	public function ping()
	{
		return $this->server->getPing();
	}

    /**
     * Validate an RCON password with the server instance
     *
     * @throws Exception if the rcon password is incorrect
     *         
     */
	public function validateRconPass($rcon)
	{
		$this->server->updatePlayers($rcon);
	}
}