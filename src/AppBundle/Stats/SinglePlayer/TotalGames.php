<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\Stat;
use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Player;

class TotalGames extends AbstractStats
{

    public function set(Player $player, Stats $stats)
    {
        $stat = new Stat('Total games', $this->totalGames($player));
        $stats->addStat($stat);
    }
}
