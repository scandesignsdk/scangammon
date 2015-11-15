<?php

namespace AppBundle\Tests\Controller;

class PlayerControllerTest extends AbstractController
{

    public function dataProvider()
    {
        return [
            ['GET', '/api/player/'],
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
