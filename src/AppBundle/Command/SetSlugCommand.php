<?php
namespace AppBundle\Command;

use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetSlugCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('reset:slug')
            ->setDescription('Reset the slug for all users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->resetPlayerSlugs();
    }

    private function resetPlayerSlugs()
    {
        /** @var PlayerRepository $playerRepo */
        $playerRepo = $this->getContainer()->get('repo.player');
        $manager = $playerRepo->getManager();

        /** @var Player[] $players */
        $players = $playerRepo->findAll();
        foreach($players as $player) {
            $player->resetSlug();
            $manager->persist($player);
        }
        $manager->flush();
    }

}
