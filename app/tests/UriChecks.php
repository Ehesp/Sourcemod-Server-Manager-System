<?php

class UriChecks extends TestCase {

	/**
	 * A basic functional test to root
	 *
	 * @return void
	 */

	public function rootUriChecks()
	{
		$crawler = $this->client->request('GET', '/');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

    public function dashUriChecks()
    {
        $crawler = $this->client->request('GET', '/dashboard');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function serversUriChecks()
    {
        $crawler = $this->client->request('GET', '/servers');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function gametypesUriChecks()
    {
        $crawler = $this->client->request('GET', '/game-types');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

}
