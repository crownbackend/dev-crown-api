<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    public function testSearch()
    {
        $client = static::createClient();

        $client->request('GET', '/api/search/search');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}