<?php

class GameTypeController extends BaseController {

	public function getView()
	{
        $server = new SourceServer('192.168.0.114', 27015);
        $server->initialize();
        print_r($server->getPlayers());
	}

}