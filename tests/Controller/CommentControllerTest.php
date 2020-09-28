<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testComments()
    {
        $client = static::createClient();

        $client->request('GET', '/api/comments/{id}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
    public function testNew()
    {
        $client = static::createClient();

        $client->request('POST', '/api/comments');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $client = static::createClient();

        $client->request('PUT', '/api/comments/{id}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteComment()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/delete/{id}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}