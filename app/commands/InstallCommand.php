<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ssms:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Installer script for SSMS setup.';

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
		$this->info("\nRunning installer script on " . App::environment() . " environment... \n");

		if ($this->option('mode') == 'install')
		{
			$question = "This installer will attempt to create a config file, create & seed database tables. Do you wish to continue? [yes|no]: ";
		}
		else
		{
			$question = "This installer will wipe all database entries & settings, do you wish to continue? [yes|no]: ";
		}

		if ($this->confirm($question))
		{
			$this->line("\nChecking if database config file is present...");

			$dbConfigFile = $this->fileName(App::environment());

			if ($this->checkFile($dbConfigFile))
			{
				$this->line("Config file exists, updating the database.");
			}
			else
			{
				$this->error("No database config file exists, please provide your database details:");

				$host = $this->ask('What is your database hostname?');
				$name = $this->ask('What is your database name?');
				$user = $this->ask('Who is your database user?');
				$password = $this->ask('What is the database user password?');

				try
				{
					$this->makeFile($dbConfigFile, $this->makeFileTemplate($host, $name, $user, $password));
				}
				catch (Exception $e)
				{
					$this->error("\nUnable to create config file, please check the FAQs: " . $e->getMessage());
				}
			}

		    try
		    {
		    	if (! Schema::hasTable('migrations'))
				{
					$this->call("migrate:install");
				}
				
				$this->call("migrate:reset");
				$this->call('migrate');
				$this->call('db:seed');

		    }
		    catch (Exception $e) 
		    {
				$this->error("\nAn error occured during database migrations (code " . $e->getCode() . "): \n   " . $e->getMessage());
				$this->question("\nHave you updated your " . App::environment() . " database configuration?");
		    }
		}
		else
		{
			$this->error("\n*** Installer aborted. ***");
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
		return [
			['mode', 'm', InputOption::VALUE_REQUIRED, 'The mode in which the installer script will run as.', null]
		];
	}

	protected function fileName($environment)
	{
        if($environment == 'production')
        {
        	return '.env.php';
        }

        return '.env.' . $environment . '.php';
	}

	protected function makeFile($file, $content)
	{
        return file_put_contents($file, $content);
	}

	protected function checkFile($file)
	{
		return file_exists($file);
	}

	protected function makeFileTemplate($host, $name, $user, $password)
	{
		return
		"<?php
			\n
			return array(
				\n
				'database.host' => $host,
				'database.name' => $name,
				'database.user' => $user,
				'database.password' => $password,
			\n
			);";
	}

}
