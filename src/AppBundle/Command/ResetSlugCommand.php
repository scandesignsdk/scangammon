<?php
namespace AppBundle\Command;

use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetSlugCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('reset:slug')
            ->setDescription('Reset the slug for players')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Player[] $players */
        $players = $this->getRepo()->findAll();
        foreach($players as $player) {
            $player->setSlug(null);
            $this->getRepo()->getManager()->persist($player);
        }
        $this->getRepo()->getManager()->flush();
    }

    /**
     * @return PlayerRepository
     */
    private function getRepo()
    {
        return $this->getContainer()->get('repo.player');
    }

}
