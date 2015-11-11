<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\GameStat;
use AppBundle\Document\GameStats;

class TotalBackGammonStats extends AbstractGameStats
{

    public function set(GameStats $stats)
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->select('COUNT(game.id)');
        $builder->where($builder->expr()->eq('game.wintype', 2));
        $result = $builder->getQuery()->getSingleScalarResult();

        if ($result == 0) {
            $stat = new GameStat('Total backgammons', $result, 0);
        } else {
            $stat = new GameStat('Total backgammons', $result, ($result / $this->totalGames()) * 100);
        }

        $stats->addStat($stat);
    }
}
