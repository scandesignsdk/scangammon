<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Player;

class AllGames extends AbstractStats
{

    public function set(Player $player, Stats $stats)
    {
        $builder = $this->gameRepository->findByPlayer($player->getId());
        $builder->setMaxResults(50);
        $builder->orderBy('game.date', 'DESC');
        $results = $builder->getQuery()->getResult();
        $stats->setGames($results);
    }
}
