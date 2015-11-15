<?php

namespace AppBundle\Tests\Controller;

class StatsControllerTest extends AbstractController
{

    public function dataProvider()
    {
        return [
            ['GET', '/api/stats/games'],
            ['GET', '/api/stats/players'],
            ['GET', '/api/stats/all'],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param string $method
     * @param string $url
     */
    public function test_actions($method, $url)
    {
        $client = static::createClient();
        $client->request($method, $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
