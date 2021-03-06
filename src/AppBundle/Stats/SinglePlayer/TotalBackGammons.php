<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\Stat;
use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Game;
use AppBundle\Entity\Player;

class TotalBackGammons extends AbstractStats
{

    public function set(Player $player, Stats $stats)
    {
        $builder = $this->gameRepository->findByPlayer($player->getId());
        $builder->select('COUNT(game.id)');
        $builder->andWhere($builder->expr()->eq('game.wintype', Game::WINTYPE_BACKGAMMON));
        $result = $builder->getQuery()->getSingleScalarResult();

        if ($result == 0) {
            $stat = new Stat('Total backgammons', $result, 0);
        } else {
            $stat = new Stat('Total backgammons', $result, round(($result / $this->totalGames($player)) * 100, 2));
        }

        $stats->addStat($stat);

    }
}
