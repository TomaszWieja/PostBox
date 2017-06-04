<?php

namespace PostBoxBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

    public function testModify()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modify');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete');
    }

    public function testGet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testGetall()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

}
