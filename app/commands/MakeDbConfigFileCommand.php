<?php

use Ssms\Artisan\FileSystem\Files;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeDbConfigFileCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ssms:dbconfig';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a database configuration file with user input';

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
		$this->line("\nChecking for existing config file...");

		$fileName = $this->filesystem->getEnvDbConfigFileName(App::environment());

		if ($this->filesystem->checkFileExists($fileName))
		{
			$this->error("File $fileName already exists!");
		}
		else
		{
			$this->error("No config file exists! Enter database details to create your file:\n");

			$host = $this->ask('Your database hostname:');
			$name = $this->ask('Your database name:');
			$user = $this->ask('Your database user:');
			$pass = $this->secret('Your database user password:');

			try
			{
				$this->filesystem->makeFile($fileName, null, $this->getTemplate($host, $name, $user, $pass));
				$this->info("Config file $fileName successfully created!");
			}
			catch (Exception $e)
			{
				$this->error("An error occured creating the file: " . $e->getMessage());
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

	protected function getTemplate($host, $name, $user, $pass)
	{
		return
		"<?php
			return array(
				'database.host' => '$host',
				'database.name' => '$name',
				'database.user' => '$user',
				'database.password' => '$pass',
			);";
	}
}