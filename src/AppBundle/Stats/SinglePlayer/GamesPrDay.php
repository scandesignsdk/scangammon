<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\PlayerGamesPrDay;
use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Player;
use Doctrine\ORM\Query\ResultSetMapping;

class GamesPrDay extends AbstractStats
{

    public function set(Player $player, Stats $stats)
    {
        $results = $this->gameRepository->getGamesPrDay($player);
        $out = [];
        foreach($results as $res) {
            $out[] = new PlayerGamesPrDay($res['counter'], $res['date']);
        }
        $stats->setGamesPrDay($out);
    }
}
