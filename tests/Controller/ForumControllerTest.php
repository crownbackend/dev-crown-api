<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ForumControllerTest extends WebTestCase
{
    public function testForums()
    {
        $client = static::createClient();

        $client->request('GET', '/api/forum');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testForum()
    {
        $client = static::createClient();

        $client->request('GET', '/api/forum/{id}/{slug}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testForumCategoryList()
    {
        $client = static::createClient();

        $client->request('GET', '/api/forums/category/list');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}