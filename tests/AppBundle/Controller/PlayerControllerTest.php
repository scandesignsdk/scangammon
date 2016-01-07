<?php

namespace Tests\AppBundle\Controller;

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
        $client = static::makeClient();
        $client->request($method, $url);
        $this->assertStatusCode(200, $client);
    }

}
