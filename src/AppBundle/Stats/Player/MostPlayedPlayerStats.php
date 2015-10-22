<?php
namespace AppBundle\Stats\Player;

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

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setMostPlayedPlayer';
    }

    public function set(PlayerStats $stats)
    {
        $player_id = $this->gameRepository->findMostGamesByPlayer();
        if ($player_id) {
            $stats->{$this->getSetter()}($this->playerRepository->find($player_id));
        }
    }
}
