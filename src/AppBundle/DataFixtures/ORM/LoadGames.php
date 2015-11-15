<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\ParamFetcher;
use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadGames implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var Player[]
     */
    private $players = [];

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for($i = 0; $i < 2; $i++) {
            $p = new Player();
            $p->setName('Player ' . $i);
            $manager->persist($p);
            $this->players[] = $p;
        }

        $manager->flush();

        for($i = 0; $i < 10; $i++) {
            $p1 = $this->randomPlayer();
            $p2 = $this->randomPlayer($p1);

            $params = new ParamFetcher();
            $params->add('p1', $p1->getId());
            $params->add('p2', $p2->getId());
            $params->add('wintype', $this->randomWinType());
            $params->add('winner', $this->faker->boolean() ? Game::P1WINNER : Game::P2WINNER);
            $params->add('date', $this->randomDate());

            $service = $this->container->get('game.service');
            $service->createGame($params);
        }

    }

    private function randomDate()
    {
        return $this->faker->dateTimeBetween('-3 days');
    }

    /**
     * @return int
     */
    private function randomWinType()
    {
        $normal = $this->faker->boolean(60);
        if ($normal) {
            return Game::WINTYPE_NORMAL;
        }

        $backgammon = $this->faker->boolean(10);
        if ($backgammon) {
            return Game::WINTYPE_BACKGAMMON;
        }

        return Game::WINTYPE_GAMMON;
    }

    /**
     * @param Player|null $not
     * @return Player
     */
    private function randomPlayer(Player $not = null)
    {
        while(true) {
            $random = $this->faker->randomElement($this->players);
            if ($not === null) {
                return $random;
            }

            if ($random->getName() !== $not->getName()) {
                return $random;
            }
        }

        return null;
    }
}
