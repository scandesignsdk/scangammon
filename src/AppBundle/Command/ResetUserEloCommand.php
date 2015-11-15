<?php
namespace AppBundle\Command;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetUserEloCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('reset:elo')
            ->setDescription('Reset the elo for all users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $calculator = $this->getContainer()->get('elo_calculator');

        /** @var Game[] $games */
        $games = $this->getContainer()->get('repo.game')->findBy([], ['date' => 'DESC']);

        /** @var Player[] $players */
        $players = $this->getContainer()->get('repo.player')->findAll();

        /** @var Player[] $playerlist */
        $playerlist = [];
        foreach($players as $player) {
            $player->setElo(Player::STARTELO);
            $playerlist[$player->getId()] = $player;
        }

        foreach($games as $game) {
            $p1 = $playerlist[$game->getPlayer1()->getId()];
            $p2 = $playerlist[$game->getPlayer2()->getId()];

            $newelo = $calculator->getNewElo($p1, $p2, $game->getWinner(), $game->getWintype());
            $p1->setElo($newelo[0]);
            $p2->setElo($newelo[1]);
        }

        foreach($playerlist as $player) {
            $this->getManager()->persist($player);
        }

        $this->getManager()->flush();
    }

    /**
     * @return PlayerRepository
     */
    protected function getRepo()
    {
        try {
            return $this->getContainer()->get('repo.player');
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getManager()
    {
        return $this->getRepo()->getManager();
    }

}
