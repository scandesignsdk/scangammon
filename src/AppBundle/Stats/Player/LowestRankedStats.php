<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStats;

class LowestRankedStats extends AbstractPlayerStats
{

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setLowestRanked';
    }

    public function set(PlayerStats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->setMaxResults(1);
        $builder->orderBy('player.elo', 'asc');
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleResult());
    }
}
