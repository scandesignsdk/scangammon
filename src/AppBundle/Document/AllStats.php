<?php
namespace AppBundle\Document;

use JMS\Serializer\Annotation as JMS;

class AllStats
{

    /**
     * @var GameStats
     *
     * @JMS\Type("AppBundle\Document\GameStats")
     * @JMS\SerializedName("gamestats")
     */
    protected $game;

    /**
     * @var PlayerStats
     *
     * @JMS\Type("AppBundle\Document\PlayerStats")
     * @JMS\SerializedName("playerstats")
     */
    protected $player;

    public function __construct()
    {
        $this->game = new GameStats();
        $this->player = new PlayerStats();
    }

    /**
     * Get Game
     *
     * @return GameStats
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set Game
     *
     * @param GameStats $game
     * @return AllStats
     */
    public function setGame(GameStats $game)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * Get Player
     *
     * @return PlayerStats
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set Player
     *
     * @param PlayerStats $player
     * @return AllStats
     */
    public function setPlayer(PlayerStats $player)
    {
        $this->player = $player;
        return $this;
    }

}
