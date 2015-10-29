<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\GameStats;

class TotalGammonStats extends AbstractGameStats
{

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setTotalGammon';
    }

    public function set(GameStats $stats)
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->select('COUNT(game.id)');
        $builder->where($builder->expr()->eq('game.wintype', 1));
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleScalarResult());
    }
}
