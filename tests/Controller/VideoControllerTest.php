<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VideoControllerTest extends WebTestCase
{
    public function testVideos()
    {
        $client = static::createClient();

        $client->request('GET', '/api/videos');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadVideo()
    {
        $client = static::createClient();

        $client->request('POST', '/api/videos/load/more');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLastVideos()
    {
        $client = static::createClient();

        $client->request('GET', '/api/last/videos');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testVideo()
    {
        $client = static::createClient();

        $client->request('GET', '/api/video/smug-1/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testCheckDownloadVideo()
    {
        $client = static::createClient();

        $client->request('POST', '/api/check/download/video');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testAddFavored()
    {
        $client = static::createClient();

        $client->request('POST', '/api/videos/add/favored');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testRemoveFavored()
    {
        $client = static::createClient();

        $client->request('POST', '/api/videos/remove/favored');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}