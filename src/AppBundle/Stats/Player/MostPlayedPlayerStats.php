<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStat;
use AppBundle\Document\PlayerStats;
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

    public function set(PlayerStats $stats)
    {
        $result = $this->gameRepository->findMostGamesByPlayer();
        $stat = new PlayerStat('Player with most games', $result['numgames'], $this->playerRepository->find($result['player']));
        $stats->addStat($stat);
    }
}
