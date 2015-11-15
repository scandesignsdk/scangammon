<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\Player\Stat;
use AppBundle\Document\Player\Stats;

class TotalPlayerStats extends AbstractPlayerStats
{

    public function set(Stats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->select('COUNT(player.id)');
        $builder->setMaxResults(1);

        $stat = new Stat('Total players', $builder->getQuery()->getSingleScalarResult());
        $stats->addStat($stat);
    }
}
