<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\Game\Stats;

interface GameStatsInterface
{

    public function set(Stats $stats);

}
