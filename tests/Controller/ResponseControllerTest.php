<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResponseControllerTest extends WebTestCase
{
    public function testAddResponse()
    {
        $client = static::createClient();

        $client->request('POST', '/api/responses');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testEditResponse()
    {
        $client = static::createClient();

        $client->request('PUT', '/api/response/1/edit');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteResponse()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/response/1/delete');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testGoodAnswer()
    {
        $client = static::createClient();

        $client->request('POST', '/api/response/answer/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}