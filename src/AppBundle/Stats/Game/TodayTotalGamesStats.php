<?php
namespace AppBundle\Stats\Game;

use AppBundle\Document\Game\Stat;
use AppBundle\Document\Game\Stats;
use Doctrine\DBAL\Types\Type;

class TodayTotalGamesStats extends AbstractGameStats
{

    public function set(Stats $stats)
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->select('COUNT(game.id)');
        $builder->where('game.date > :hours');
        $builder->setParameter(':hours', new \DateTime('-24 hours'), Type::DATETIME);
        $result = $builder->getQuery()->getSingleScalarResult();

        $stat = new Stat('Games last 24H', $result);
        $stats->addStat($stat);
    }
}
