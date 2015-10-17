<?php
namespace AppBundle\Stats\Game;

use AppBundle\Entity\GameRepository;
use AppBundle\Stats\StatsInterface;

abstract class AbstractGameStats implements GameStatsInterface, StatsInterface
{

    /**
     * @var GameRepository
     */
    protected $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return string
     */
    abstract protected function getSetter();

}
