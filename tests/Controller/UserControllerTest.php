<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testProfile()
    {
        $client = static::createClient();

        $client->request('GET', '/api/profile/john');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
    public function testEdit()
    {
        $client = static::createClient();

        $client->request('PUT', '/api/profile/edit/');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testVideos()
    {
        $client = static::createClient();

        $client->request('GET', '/api/profile/videos/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testTopics()
    {
        $client = static::createClient();

        $client->request('GET', '/api/profile/topics/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteAccount()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/profile/delete/account/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}