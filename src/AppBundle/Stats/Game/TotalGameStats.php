<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\GameStat;
use AppBundle\Document\GameStats;

class TotalGameStats extends AbstractGameStats
{

    public function set(GameStats $stats)
    {
        $stat = new GameStat('Total games played', $this->totalGames());
        $stats->addStat($stat);
    }

}
