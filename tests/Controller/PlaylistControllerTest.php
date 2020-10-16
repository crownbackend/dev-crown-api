<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlaylistControllerTest extends WebTestCase
{
    public function testPlaylists()
    {
        $client = static::createClient();

        $client->request('GET', '/api/playlists');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadMorePlaylists()
    {
        $client = static::createClient();

        $client->request('GET', '/api/playlists/load/more/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testShow()
    {
        $client = static::createClient();

        $client->request('GET', '/api/playlist/slug-2/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadMorePlaylistVideos()
    {
        $client = static::createClient();

        $client->request('POST', '/api/playlist/videos/load/more/1');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}