<?php
namespace AppBundle\Event\Game;

use AppBundle\Entity\Game;
use Symfony\Component\EventDispatcher\Event;

class CreateEvent extends Event
{

    /**
     * @var Game
     */
    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Get Game
     *
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

}
