<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\Player\Stat;
use AppBundle\Document\Player\Stats;

class PlayerWithHighestWinPercent extends AbstractPlayerStats
{

    public function set(Stats $stats)
    {
        $player = $this->playerRepository->getHighestWinPercent();
        $stat = new Stat('Highest win percent', $player->getWinPercent(), $player);
        $stats->addStat($stat);
    }
}
