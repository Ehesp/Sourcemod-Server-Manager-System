<?php

use Ssms\Artisan\FileSystem\Files;
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
	protected $description = 'Installer script for SSMS setup';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->filesystem = new Files();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$configFile = $this->filesystem->getEnvDbConfigFileName(App::environment());

		if (! $this->filesystem->checkFileExists($configFile))
		{
			$this->error("\nNo database configuration found.\nPlease create a $configFile file in your root directory with your database details.\n-> Alternativly run the `php artisan ssms:dbconfig` helper command.");
		}
		else
		{
			$this->line("\nRunning installer script on " . App::environment() . " environment... \n");
		
			if ($this->confirm("This installer will attempt to create a config file, create & seed database tables. Do you wish to continue? [yes|no]: "))
			{
				if (Schema::hasTable('migrations'))
				{
					$continue = $this->confirm("Previous migrations detected. This installer will reset all tables and settings, are you sure you want to continue? [yes|no] :");
				}

				if ($continue)
				{
					try
			   		{
						if (! Schema::hasTable('migrations'))
						{
							$this->call("migrate:install");
						}
						
						$this->call("migrate:reset");
						$this->call("migrate");
						$this->call("db:seed");
						$this->info("Installer complete!");
			   		}
					catch (Exception $e)
					{
						$this->error("\nAn error occured during database migrations (code " . $e->getCode() . "): \n   " . $e->getMessage());
						$this->info("\nCheck your $configFile database credentials!");
					}
				}
				else
				{
					$this->error("\n*** Installer aborted. ***");
				}
			}
			else
			{
				$this->error("\n*** Installer aborted. ***");
			}
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



}
