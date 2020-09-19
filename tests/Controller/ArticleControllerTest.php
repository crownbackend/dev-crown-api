<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testArticles()
    {
        $client = static::createClient();

        $client->request('GET', '/api/articles');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLastArticlesHome()
    {
        $client = static::createClient();

        $client->request('GET', '/api/articles/home');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLastArticles()
    {
        $client = static::createClient();

        $client->request('GET', '/api/last/articles/{date}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testArticle()
    {
        $client = static::createClient();

        $client->request('GET', '/api/article/{slug}/{id}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}