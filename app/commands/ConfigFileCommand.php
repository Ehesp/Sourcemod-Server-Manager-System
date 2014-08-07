<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ssms\Support\Helpers\Environment;

class ConfigFileCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ssms:config';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a configuration file for the application';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->env = new Environment();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info("Checking for existing config file...");

		$fileName = $this->env->configFileName();

		if (File::exists($fileName))
		{
			$this->error("File $fileName already exists - please delete it!");
			$this->abort();
		}
		else
		{
			$this->error("No config file exists! Enter database details to create your file:");

			$type = $this->ask("What database driver type are you using? [mysql|sqlite|pgsql|sqlsrv]: ");

			$file = null;
			$host = '';
			$name = '';
			$user = '';
			$pass = '';

			if($type == 'sqlite')
			{
				$file = $this->ask('Where is your sqlite database file located (from base root)? Leave blank for the default app/database/production.sqlite file: ');
				$file == '' ? $file = null : $file = $file;
			}
			elseif($type == 'mysql' || $type == 'pgsql' || $type == 'sqlsrv')
			{
				$host = $this->ask('Your database hostname:');
				$name = $this->ask('Your database name:');
				$user = $this->ask('Your database user:');
				$pass = $this->secret('Your database user password:');
			}
			else
			{
				$this->error("Invalid database driver type.");
				$this->abort();
			}

			try
			{
				File::put($fileName, $this->getTemplate($type, $host, $name, $user, $pass, $file));
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

	/**
	 * Abort message
	 *
	 */
	protected function abort()
	{
		return $this->error("\n*** Aborted!. ***") . die();
	}

	/**
	 * Returns a string template to create the config file with
	 *
	 * @return array
	 */
	protected function getTemplate($type, $host, $name, $user, $pass, $file)
	{
		$randKey = Str::random(32);

		$template =
		"<?php
			return array(
				'application_key' => '$randKey',
				'database_type' => '$type',
				'database_host' => '$host',
				'database_name' => '$name',
				'database_user' => '$user',
				'database_password' => '$pass',";

		! is_null($file) ? $template .= "\n'database.file' => '$file',\n" : '';

		$template .= "\n);";

		return $template;
	}
}