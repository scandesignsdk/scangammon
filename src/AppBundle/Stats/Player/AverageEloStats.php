<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\Player\Stat;
use AppBundle\Document\Player\Stats;

class AverageEloStats extends AbstractPlayerStats
{

    public function set(Stats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->select('AVG(player.elo)');
        $builder->setMaxResults(1);

        $stat = new Stat('Average elo rank', $builder->getQuery()->getSingleScalarResult());
        $stats->addStat($stat);
    }
}
