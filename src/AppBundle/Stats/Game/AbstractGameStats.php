<?php
namespace AppBundle\Stats\Game;

use AppBundle\Entity\GameRepository;
use AppBundle\Stats\StatsInterface;

abstract class AbstractGameStats implements GameStatsInterface, StatsInterface
{

    /**
     * @var GameRepository
     */
    protected $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return int
     */
    protected function totalGames()
    {
        $builder = $this->gameRepository->createQueryBuilder('game');
        $builder->select('COUNT(game.id)');
        $builder->setCacheable(true);
        $query = $builder->getQuery();
        $query->useResultCache(true, 30, 'total_games');
        return $query->getSingleScalarResult();
    }

}
