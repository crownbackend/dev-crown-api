<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();

        $client->request('POST', '/api/register', [
            "username" => "john",
            "email" => "john@doe.fr"
        ]);

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testConfirmAccount()
    {
        $client = static::createClient();

        $client->request('GET', '/api/register/confirm/account/{token}');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testSendNewPassword()
    {
        $client = static::createClient();

        $client->request('POST', '/api/forgot/password');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testConfirmPassword()
    {
        $client = static::createClient();

        $client->request('POST', '/api/forgot/password/DCJHBDZGGVZEZ251EZEZZET');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testVerifyUsername()
    {
        $client = static::createClient();

        $client->request('GET', '/api/verify/username/john');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }

    public function testVerifyEmail()
    {
        $client = static::createClient();

        $client->request('GET', '/api/verify/email/john@doe.fr');

        $this->assertJson(200, $client->getResponse()->getStatusCode());
    }
}