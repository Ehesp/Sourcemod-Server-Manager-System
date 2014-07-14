<?php namespace Ssms\Steam;

use SourceServer;

class Server {

	protected $ip;

	protected $port;

	public function __construct($ip, $port)
	{
		$this->server = new SourceServer($ip, $port);
		$this->initialize($this->server);
	}

	private function initialize($s)
	{
		error_reporting(E_ALL ^ E_USER_NOTICE);
		$s->initialize();
	}

	private function convert($data)
	{
		return json_encode($data);
	}

	public function info()
	{
		return $this->server->getServerInfo();
	}

	public function players()
	{
		return $this->convert($this->server->getPlayers());
	}

	public function ping()
	{
		return $this->server->getPing();
	}
}