<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TopicControllerTest extends WebTestCase
{
    public function testTopic()
    {
        $client = static::createClient();

        $client->request('GET', '/api/topic/{id}/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
    public function testTopics()
    {
        $client = static::createClient();

        $client->request('GET', '/api/last/topics');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testTopicsShowMore()
    {
        $client = static::createClient();

        $client->request('GET', '/api/topics/show/more/10-10-2020/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testAddTopic()
    {
        $client = static::createClient();

        $client->request('POST', '/api/topic/new');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testEditTopic()
    {
        $client = static::createClient();

        $client->request('PUT', '/api/topic/edit/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTopic()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/topic/delete/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}