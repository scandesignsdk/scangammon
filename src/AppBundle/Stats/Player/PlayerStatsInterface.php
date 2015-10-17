<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStats;

interface PlayerStatsInterface
{

    public function set(PlayerStats $stats);

}
