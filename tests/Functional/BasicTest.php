<?php

namespace app\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase
{
    public function testEnvironnementIsOk(): void
    {
        $client = static::createClient();
        $client->request ('GET', '/');
        $this->assertResponseIsSuccessful();
    }
}