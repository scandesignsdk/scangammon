<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\GameStats;

class TotalGameStats extends AbstractGameStats
{

    public function set(GameStats $stats)
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->select('COUNT(game.id)');
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleScalarResult());
    }

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setTotal';
    }
}
