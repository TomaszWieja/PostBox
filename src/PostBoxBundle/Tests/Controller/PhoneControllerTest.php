<?php

namespace PostBoxBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PhoneControllerTest extends WebTestCase
{
    public function testAddphone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addPhone');
    }

}
