<?php
namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class AbstractController extends WebTestCase
{

    /**
     * {@inheritdoc}
     */
    protected static function getFixtureList()
    {
        return [
            'AppBundle\DataFixtures\ORM\LoadGames'
        ];
    }

}
