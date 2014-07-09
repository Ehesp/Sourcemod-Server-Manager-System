<?php namespace Ssms\FileSystem;

class Files {

	public function makeFile($file, $path = '', $content)
	{
		return file_put_contents($path.$file, $content);
	}

	public function checkFileExists($file, $path = '')
	{
		return file_exists($path.$file);
	}

	public function getEnvDbConfigFileName($environment)
	{
		if ($environment == 'production')
		{
			return '.env.php';
		}
		else
		{
			return '.env.' . $environment . '.php';
		}
	}
}