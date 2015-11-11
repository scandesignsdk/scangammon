<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStat;
use AppBundle\Document\PlayerStats;

class TotalPlayerStats extends AbstractPlayerStats
{

    public function set(PlayerStats $stats)
    {
        $builder = $this->playerRepository->createQueryBuilder('player');
        $builder->select('COUNT(player.id)');
        $builder->setMaxResults(1);

        $stat = new PlayerStat('Total players', $builder->getQuery()->getSingleScalarResult());
        $stats->addStat($stat);
    }
}
