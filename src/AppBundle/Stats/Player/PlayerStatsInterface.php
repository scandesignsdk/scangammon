<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\Player\Stats;

interface PlayerStatsInterface
{

    public function set(Stats $stats);

}
