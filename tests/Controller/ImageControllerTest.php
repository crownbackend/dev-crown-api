<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageControllerTest extends WebTestCase
{
    public function testUploadImages()
    {
        $client = static::createClient();

        $client->request('POST', '/api/images/upload');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testImages()
    {
        $client = static::createClient();

        $client->request('GET', '/api/images/{id}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteImage()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/image/{id}/{userId}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}