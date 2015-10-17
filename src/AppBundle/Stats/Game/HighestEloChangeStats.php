<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\GameStats;

class HighestEloChangeStats extends AbstractGameStats
{

    public function set(GameStats $stats)
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->orWhere(
            $builder->expr()->gt('game.player1Elochange', 0),
            $builder->expr()->gt('game.player2Elochange', 0)
        );
        $builder->orderBy('game.player1Elochange', 'desc');
        $builder->addOrderBy('game.player2Elochange', 'desc');
        $builder->setMaxResults(1);
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleResult());
    }

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setHigestEloChange';
    }
}
