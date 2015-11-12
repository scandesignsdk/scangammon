<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStat;
use AppBundle\Document\PlayerStats;
use AppBundle\Entity\GameRepository;
use AppBundle\Entity\PlayerRepository;

class LeastPlayedPlayerStats extends AbstractPlayerStats
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
        $result = $this->gameRepository->findLeastGamesByPlayer();
        $stat = new PlayerStat('Player with least games', $result['numgames'], $this->playerRepository->find($result['player']));
        $stats->addStat($stat);
    }
}
