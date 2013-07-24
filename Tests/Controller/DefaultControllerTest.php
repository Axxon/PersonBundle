<?php

namespace Black\Bundle\PersonBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Default controller test.
 *
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * test index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
