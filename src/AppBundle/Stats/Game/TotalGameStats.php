<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\Game\Stat;
use AppBundle\Document\Game\Stats;

class TotalGameStats extends AbstractGameStats
{

    public function set(Stats $stats)
    {
        $stat = new Stat('Total games played', $this->totalGames());
        $stats->addStat($stat);
    }

}
