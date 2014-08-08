<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ssms\Steam\Server;
use Ssms\Repositories\Server\ServerRepository;

class RefreshCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ssms:refresh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refreshes the servers and fires trigger checks';

	protected $servers;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->servers = \App::make('Ssms\Repositories\Server\ServerRepository');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Don't run if there are no servers
		if($this->servers->count() == 0)
		{
			$this->info('There are no servers to refresh!');
			$this->abort();
		}

		$this->info('Running server refrehes:');

		// Get all the server infomtation
		$servers = $this->servers->getAll(['id', 'ip', 'port', 'rcon_password']);

		// Loop through the servers
		foreach ($servers as $server)
		{
			// Grab the server model
			$db = $this->servers->getFirst('id', $server['id']);

			// First, see if we're able to connect to the server
			// If not, add "1" onto the retries field via the model method.
			if (! $s = $this->canConnect($server['ip'], $server['port']))
			{
				$db->addRetry();
				$this->comment('{'. $server['id'] .'} Connection failed - Retry count added!');
			}
			// Can connect, reset retries
			else
			{
				$db->resetRetry();
			}

			// Next, validate the RCON password in the database
			// If it's invalid, set the RCON warning flag
			if (! $this->validRcon($s, $server['rcon_password']))
			{
				$db->setFlags([4]);
				$this->comment('{'. $server['id'] .'} Incorrect RCON password detcted - Setting flag!');
			}
			// Remove any RCON warning flags
			else
			{
				$db->removeFlags([4]);
			}

			// Try to perform the refresh with the server information via the model method
			try
			{
				$db->refresh($s->info());
			}
			catch (Exception $e)
			{
				$this->comment('{'. $server['id'] .'} Refresh failed: ' . $e->getMessage());
				break;
			}

			$this->info('{'. $server['id'] .'} Successfully refreshed!');

		}

		$this->info("Refresh process complete!\n");

		// Run the command "php artisan ssms:trigger"
		$this->call('ssms:trigger');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

	/**
	 * Abort message
	 *
	 */
	protected function abort()
	{
		return $this->error("\n*** Aborted!. ***") . die();
	}

	/**
	 * Check whether SteamCondenser is able to connect to the server
	 *
	 */
	protected function canConnect($ip, $port)
	{
		try
		{
			$server = new Server($ip, $port);
		}
		catch (Exception $e)
		{
			return false;
		}

		return $server;
	}

	/**
	 * Validates the given RCON password
	 *
	 */
	protected function validRcon($server, $password)
	{
		try
		{
			$server->validateRconPass($password);
		}
		catch (Exception $e)
		{
			return false;
		}

		return true;
	}
}
