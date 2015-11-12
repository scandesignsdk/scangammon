<?php
namespace AppBundle\Command;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateWinPercentCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('update:winpercent')
            ->setDescription('Update win percent on users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $playerGames = [];
        $games = $this->getContainer()->get('repo.game')->findAll();
        /** @var Game $game */
        foreach ($games as $game) {
            if (!isset($playerGames[$game->getPlayer1()->getId()])) {
                $playerGames[$game->getPlayer1()->getId()]['win'] = 0;
                $playerGames[$game->getPlayer1()->getId()]['lost'] = 0;
            }

            if (!isset($playerGames[$game->getPlayer2()->getId()])) {
                $playerGames[$game->getPlayer2()->getId()]['win'] = 0;
                $playerGames[$game->getPlayer2()->getId()]['lost'] = 0;
            }

            if ($game->getWinner() === Game::P1WINNER) {
                $playerGames[$game->getPlayer1()->getId()]['win'] += 1;
                $playerGames[$game->getPlayer2()->getId()]['lost'] += 1;
            } else {
                $playerGames[$game->getPlayer2()->getId()]['win'] += 1;
                $playerGames[$game->getPlayer1()->getId()]['lost'] += 1;
            }
        }

        $playerManager = $this->getContainer()->get('repo.player')->getManager();
        foreach($playerGames as $playerId => $data) {
            $total = $data['win'] + $data['lost'];
            if ($data['win'] == 0) {
                $winpercent = 0;
            } else {
                $winpercent = ($data['win'] / $total) * 100;
            }

            /** @var Player $player */
            $player = $this->getContainer()->get('repo.player')->find($playerId);
            $player->setWinPercent($winpercent);
            $playerManager->persist($player);

        }

        $playerManager->flush();
    }

}
