<?php namespace Ssms\Support\Helpers;

class Environment {

    /**
     * Creates a new SecToHrMinSec instance
     *
     */
	public function __construct()
	{
		$this->env = \App::environment();
	}

   	/**
	 * Returns the name of the config file for the current environment
	 *
	 * @return string
	 */
	public function configFileName()
	{
		if ($this->env == 'production')
		{
			return '.env.php';
		}
		else
		{
			return '.env.' . $this->env . '.php';
		}
	}

}