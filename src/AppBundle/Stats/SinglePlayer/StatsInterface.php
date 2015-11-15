<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Player;

interface StatsInterface
{

    public function set(Player $player, Stats $stats);

}
