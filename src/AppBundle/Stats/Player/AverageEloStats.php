<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStats;

class AverageEloStats extends AbstractPlayerStats
{

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setAvgElo';
    }

    public function set(PlayerStats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->select('AVG(player.elo)');
        $builder->setMaxResults(1);
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleScalarResult());
    }
}
