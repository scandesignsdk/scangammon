<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStat;
use AppBundle\Document\PlayerStats;

class PlayerWithHighestWinPercent extends AbstractPlayerStats
{

    public function set(PlayerStats $stats)
    {
        $player = $this->playerRepository->getHighestWinPercent();
        $stat = new PlayerStat('Highest win percent', $player->getWinPercent(), $player);
        $stats->addStat($stat);
    }
}
