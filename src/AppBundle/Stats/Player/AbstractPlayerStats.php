<?php
namespace AppBundle\Stats\Player;

use AppBundle\Entity\PlayerRepository;
use AppBundle\Stats\StatsInterface;

abstract class AbstractPlayerStats implements PlayerStatsInterface, StatsInterface
{

    /**
     * @var PlayerRepository
     */
    protected $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @return string
     */
    abstract protected function getSetter();

}
