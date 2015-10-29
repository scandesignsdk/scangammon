<?php
namespace AppBundle\Command;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
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

        $manager = $this->getContainer()->get('repo.player')->getManager();
        foreach($playerlist as $player) {
            $manager->persist($player);
        }

        $manager->flush();
    }

}
