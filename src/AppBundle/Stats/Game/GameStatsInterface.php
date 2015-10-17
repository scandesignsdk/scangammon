<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\GameStats;

interface GameStatsInterface
{

    public function set(GameStats $stats);

}
