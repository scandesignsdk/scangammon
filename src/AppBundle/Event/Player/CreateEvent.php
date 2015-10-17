<?php
namespace AppBundle\Event\Player;

use AppBundle\Entity\Player;
use Symfony\Component\EventDispatcher\Event;

class CreateEvent extends Event
{

    /**
     * @var Player
     */
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * Get Player
     *
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

}
