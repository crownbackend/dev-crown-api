<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TechnologyControllerTest extends WebTestCase
{
    public function testTechnologies()
    {
        $client = static::createClient();

        $client->request('GET', '/api/technologies');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
    public function testTechnology()
    {
        $client = static::createClient();

        $client->request('GET', '/api/technology/slug-1/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadLastMoreTechnologies()
    {
        $client = static::createClient();

        $client->request('GET', '/api/technologies/load/more/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadMoreVideoTechnology()
    {
        $client = static::createClient();

        $client->request('GET', '/api/technology/videos/load/more/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}