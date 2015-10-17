<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\GameStats;

class LowestEloChangeStats extends AbstractGameStats
{

    public function set(GameStats $stats)
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->orWhere(
            $builder->expr()->lt('game.player1Elochange', 0),
            $builder->expr()->lt('game.player2Elochange', 0)
        );
        $builder->orderBy('game.player1Elochange', 'asc');
        $builder->addOrderBy('game.player2Elochange', 'asc');
        $builder->setMaxResults(1);
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleResult());
    }

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setLowestEloChange';
    }
}
