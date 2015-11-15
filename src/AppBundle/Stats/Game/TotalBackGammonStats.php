<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\Game\Stat;
use AppBundle\Document\Game\Stats;

class TotalBackGammonStats extends AbstractGameStats
{

    public function set(Stats $stats)
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->select('COUNT(game.id)');
        $builder->where($builder->expr()->eq('game.wintype', 2));
        $result = $builder->getQuery()->getSingleScalarResult();

        if ($result == 0) {
            $stat = new Stat('Total backgammons', $result, 0);
        } else {
            $stat = new Stat('Total backgammons', $result, round(($result / $this->totalGames()) * 100, 2));
        }

        $stats->addStat($stat);
    }
}
