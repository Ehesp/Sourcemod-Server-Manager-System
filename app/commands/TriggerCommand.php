<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ssms\Steam\Server;

class TriggerCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ssms:trigger';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checks the servers for any triggers which need setting';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Don't run if there are no servers
		if(Ssms\Server::count() == 0)
		{
			$this->info('There are no servers to run triggers against!');
			$this->abort();
		}

		$this->info('Running server triggers:');

		$servers = Ssms\Server::all();

		foreach ($servers as $servers) 
		{
			// IF: retries count > value : set flag 6
			// IF: retries count < value > 0 : set flag 5
		}


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
}