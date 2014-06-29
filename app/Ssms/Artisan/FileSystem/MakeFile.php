<?php namespace Ssms\Artisan\FileSystem;

class MakeFile {

	public function makeFile($file, $path = '', $content)
	{
		return file_put_contents($path.$file, $content);
	}

	public function checkFileExists($file, $path = '')
	{
		return file_exists($path.$file);
	}
}