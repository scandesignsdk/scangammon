<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStat;
use AppBundle\Document\PlayerStats;

class AverageEloStats extends AbstractPlayerStats
{

    public function set(PlayerStats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->select('AVG(player.elo)');
        $builder->setMaxResults(1);

        $stat = new PlayerStat('Average elo rank', $builder->getQuery()->getSingleScalarResult());
        $stats->addStat($stat);
    }
}
