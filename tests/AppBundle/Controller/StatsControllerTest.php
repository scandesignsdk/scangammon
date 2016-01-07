<?php

namespace Tests\AppBundle\Controller;

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
        $client = static::makeClient();
        $client->request($method, $url);
        $this->assertStatusCode(200, $client);
    }

}
