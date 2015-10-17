<?php
namespace AppBundle\Stats\Player;

use AppBundle\Document\PlayerStats;
use AppBundle\Entity\GameRepository;
use AppBundle\Entity\PlayerRepository;

class MostPlayedStats extends AbstractPlayerStats
{

    /**
     * @var GameRepository
     */
    private $gameRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        parent::__construct($playerRepository);
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return string
     */
    protected function getSetter()
    {
        return 'setMostPlayed';
    }

    public function set(PlayerStats $stats)
    {
        /*
        $builder = $this->gameRepository->createQueryBuilder('player');
        $builder->setMaxResults(1);
        $builder->orderBy('player.elo', 'desc');
        $stats->{$this->getSetter()}($builder->getQuery()->getSingleResult());
        */
    }
}
