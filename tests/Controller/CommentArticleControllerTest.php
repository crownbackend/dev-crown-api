<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentArticleControllerTest extends WebTestCase
{
    public function testComments()
    {
        $client = static::createClient();

        $client->request("GET", "/api/comments/article/{id}");

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testNew()
    {
        $client = static::createClient();

        $client->request("POST", "/api/comments/article");

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $client = static::createClient();

        $client->request("PUT", "/api/comments/article/{id}");

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testDelete()
    {
        $client = static::createClient();

        $client->request("DELETE", "/api/comments/article/{id}");

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}