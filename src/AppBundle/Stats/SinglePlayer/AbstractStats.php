<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Entity\GameRepository;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use AppBundle\Stats\StatsInterface as MainStatsInterface;

abstract class AbstractStats implements StatsInterface, MainStatsInterface
{

    /**
     * @var PlayerRepository
     */
    protected $playerRepository;

    /**
     * @var GameRepository
     */
    protected $gameRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @param Player $player
     * @return int
     */
    protected function totalGames(Player $player)
    {
        $builder = $this->gameRepository->findByPlayer($player->getId());
        $builder->select('COUNT(game.id)');
        return $builder->getQuery()->getSingleScalarResult();
    }

}
