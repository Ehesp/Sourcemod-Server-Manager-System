<?php

class UriCheckTest extends TestCase {

    /**
     * A basic functional test to root
     *
     * @return void
     */

    public function testRootUri()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testDashUri()
    {
        $this->client->request('GET', '/dashboard');
        $this->assertResponseOk();
    }

    public function testServersUri()
    {
        $this->client->request('GET', '/servers');
        $this->assertResponseOk();
    }

    public function testGametypesUri()
    {
        $this->client->request('GET', '/game-types');
        $this->assertResponseOk();
    }

}