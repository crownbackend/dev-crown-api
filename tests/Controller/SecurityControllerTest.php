<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginApi()
    {
        $client = static::createClient();

        $client->request('POST', '/api/login_check');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testCheckToken()
    {
        $client = static::createClient();

        $client->request('GET', '/api/check/login/verify/token');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/api/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLogout()
    {
        $client = static::createClient();

        $client->request('GET', '/api/logout');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}