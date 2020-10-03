<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testBackOffice()
    {
        $client = static::createClient();

        $client->request('GET', '/031216');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}