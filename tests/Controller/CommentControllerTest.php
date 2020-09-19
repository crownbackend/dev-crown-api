<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testComments()
    {
        $client = static::createClient();

        $client->request("GET", "/api/comments/article/{id}");

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}