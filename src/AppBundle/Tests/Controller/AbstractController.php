<?php
namespace AppBundle\Tests\Controller;

use IC\Bundle\Base\TestBundle\Test\Functional\WebTestCase;

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
