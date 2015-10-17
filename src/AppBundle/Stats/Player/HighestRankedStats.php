<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStats;

class HighestRankedStats extends AbstractPlayerStats
{

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setHighestRanked';
    }

    public function set(PlayerStats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->setMaxResults(1);
        $builder->orderBy('player.elo', 'desc');
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleResult());
    }
}
