<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStat;
use AppBundle\Document\PlayerStats;

class PlayerWithLowestWinPercent extends AbstractPlayerStats
{

    public function set(PlayerStats $stats)
    {
        $player = $this->playerRepository->getLowestWinPercent();
        $stat = new PlayerStat('Lowest win percent', $player->getWinPercent(), $player);
        $stats->addStat($stat);
    }
}
