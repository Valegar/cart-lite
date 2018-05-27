<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testProductsList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(12, $crawler->filter('.product-item')->count());
    }
}
