<?php
namespace AppBundle\Document;

use AppBundle\Document\Game\Stats as GameStats;
use AppBundle\Document\Player\Stats as PlayerStats;
use JMS\Serializer\Annotation as JMS;

class AllStats
{

    /**
     * @var GameStats
     *
     * @JMS\Type("AppBundle\Document\Game\Stats")
     * @JMS\SerializedName("gamestats")
     */
    protected $game;

    /**
     * @var PlayerStats
     *
     * @JMS\Type("AppBundle\Document\Player\Stats")
     * @JMS\SerializedName("playerstats")
     */
    protected $player;

    public function __construct()
    {
        $this->game = new Game\Stats();
        $this->player = new Player\Stats();
    }

    /**
     * Get Game
     *
     * @return Game\Stats
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set Game
     *
     * @param Game\Stats $game
     * @return AllStats
     */
    public function setGame(Game\Stats $game)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * Get Player
     *
     * @return Player\Stats
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set Player
     *
     * @param Player\Stats $player
     * @return AllStats
     */
    public function setPlayer(Player\Stats $player)
    {
        $this->player = $player;
        return $this;
    }

}
