<?php

class GameTypeController extends BaseController {

	public function getView()
	{

        try {
        error_reporting(0);
        SteamSocket::setTimeout(2000);
        $server = new SourceServer('46.4.99.5', 28080);
        $server->initialize();
        //return $server->getRules();
            $players = $server->getPlayers(); // Player pings are only available if the RCON password is provided
            echo "<table>";
            echo "<tr><th>Name</th><th>Score</th></tr>";
            foreach($players as $player) {
                echo "<tr>";
                echo "<td>{$player->getName()}</td>";
                echo "<td>{$player->getScore()}</td>";
                echo "</tr>";
            }
            echo "</table>";

        } catch (Exceptio $e) {
            echo "Timeout or cannot connect to server";
        }
	}

}