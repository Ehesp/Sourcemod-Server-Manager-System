<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		/*
		* Use the array driver during the unit testing
		*/
		$app['config']->set('cache.driver', 'array');

		return require __DIR__.'/../../bootstrap/start.php';
	}

}