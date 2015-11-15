<?php
namespace AppBundle\Service;

use AppBundle\Document\SinglePlayer\PlayerGamesPrDay;
use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Game;
use AppBundle\Entity\GameRepository;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class PlayerService
{

    /**
     * @var PlayerRepository
     */
    private $playerRepository;
    /**
     * @var GameRepository
     */
    private $gameRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @param string $name
     * @return Player
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function addPlayer($name)
    {
        $player = $this->playerRepository->findOneBy(['name' => $name]);
        if (! $player) {
            $player = new Player();
            $player->setName($name);
            try {
                $this->playerRepository->getManager()->persist($player);
                $this->playerRepository->getManager()->flush();
                return $player;
            } catch (\Exception $e) {
                throw $e;
            }
        }

        throw new \InvalidArgumentException();
    }

    /**
     * @param string $slug
     * @return Player
     * @throws \InvalidArgumentException
     */
    public function singlePlayer($slug)
    {
        $player = $this->playerRepository->findOneBy(['slug' => $slug]);
        if ($player instanceof Player) {
            return $player;
        }

        throw new \InvalidArgumentException();
    }

    /**
     * @param array $order
     * @return array
     */
    public function findPlayers(array $order = array())
    {
        return $this->playerRepository->findBy([], $order);
    }

}
