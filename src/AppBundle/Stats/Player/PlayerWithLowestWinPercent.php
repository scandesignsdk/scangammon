<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\Player\Stat;
use AppBundle\Document\Player\Stats;

class PlayerWithLowestWinPercent extends AbstractPlayerStats
{

    public function set(Stats $stats)
    {
        $player = $this->playerRepository->getLowestWinPercent();
        $stat = new Stat('Lowest win percent', $player->getWinPercent(), $player);
        $stats->addStat($stat);
    }
}
