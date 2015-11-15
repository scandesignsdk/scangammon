<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\Player\Stat;
use AppBundle\Document\Player\Stats;
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

    public function set(Stats $stats)
    {
        $result = $this->gameRepository->findLeastGamesByPlayer();
        $stat = new Stat('Player with least games', $result['numgames'], $this->playerRepository->find($result['player']));
        $stats->addStat($stat);
    }
}
