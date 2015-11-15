<?php

namespace AppBundle\Tests\Controller;

class GameControllerTest extends AbstractController
{

    public function dataProvider()
    {
        return [
            ['GET', '/api/game/'],
            ['GET', '/api/game/players?p1=1&p2=2'],
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
