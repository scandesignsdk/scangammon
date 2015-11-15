<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\Stat;
use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Player;

class Wins extends AbstractStats
{

    public function set(Player $player, Stats $stats)
    {
        $builder = $this->gameRepository->findWonGamesByPlayer($player->getId());
        $builder->select($builder->expr()->count('game.id'));
        $value = $builder->getQuery()->getSingleScalarResult();

        if ($value == 0) {
            $stat = new Stat('Total wins', $value, 0);
        } else {
            $stat = new Stat('Total wins', $value, ($value / $this->totalGames($player)) * 100);
        }

        $stats->addStat($stat);
    }
}
