<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStats;

class TotalPlayerStats extends AbstractPlayerStats
{

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setTotal';
    }

    public function set(PlayerStats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->select('COUNT(player.id)');
        $builder->setMaxResults(1);
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleScalarResult());
    }
}
