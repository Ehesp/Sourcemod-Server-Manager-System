<?php namespace Ssms\Steam;

use SourceServer;
use Ssms\Support\Helpers\SecToHrMinSec;
use Ssms\Server as ServerModel;
use SteamId;

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
     * @var string The rcon password for the server
     */
    protected $rcon;

    /**
     * Creates a new SourceServer instance
     *
     */
	public function __construct($ip, $port, $rcon = null)
	{
		$this->server = new SourceServer($ip, $port);
		$this->initializeServer($this->server);

        $this->setRcon($rcon);
	}

    /**
     * Initalize the server details
     * Turn off user notices from SteamCondenser
     *
     */
	private function initializeServer($s)
	{
		error_reporting(E_ALL ^ E_USER_NOTICE);
		$s->initialize();
	}

    /**
     * Sets the RCON password for the server instance
     *
     */
    public function setRcon($string)
    {
        $this->rcon = $string;

        return $this;
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
     * Return the server instance current players information
     *
     */
	public function players()
	{
        $res = [];

        $players = $this->server->getPlayers($this->rcon);

        $count = 0;

        foreach ($players as $key => $player)
        {
            if ($player->getSteamId() == 'BOT')
                $res[$count]['community_id'] = 'BOT';
            elseif ($player->getSteamId() == null)
                $res[$count]['community_id'] = 'ERR';
            else
                $res[$count]['community_id'] = SteamId::convertSteamIdToCommunityId($player->getSteamId());

            $res[$count]['steam_id'] = $player->getSteamId() == null ? 'Steam ID unavailable!' : $player->getSteamId();
            $res[$count]['name'] = $player->getName() == '' ? false : $player->getName();
            $res[$count]['score'] = $player->getScore();
            $res[$count]['ping'] = $player->getPing();
            $res[$count]['connection_time'] = with(new SecToHrMinSec($player->getConnectTime()))->convert();
            $res[$count]['state'] = $player->getState();
            $res[$count]['ip_address'] = $player->getIpAddress();

            $count++;
        }

		return json_encode($res);
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