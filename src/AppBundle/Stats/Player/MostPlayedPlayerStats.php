<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\Player\Stat;
use AppBundle\Document\Player\Stats;
use AppBundle\Entity\GameRepository;
use AppBundle\Entity\PlayerRepository;

class MostPlayedPlayerStats extends AbstractPlayerStats
{

    /**
     * @var GameRepository
     */
    private $gameRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        parent::__construct($playerRepository);
        $this->gameRepository = $gameRepository;
    }

    public function set(Stats $stats)
    {
        $result = $this->gameRepository->findMostGamesByPlayer();
        $stat = new Stat('Player with most games', $result['numgames'], $this->playerRepository->find($result['player']));
        $stats->addStat($stat);
    }
}
