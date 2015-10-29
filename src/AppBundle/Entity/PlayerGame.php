<?php
namespace AppBundle\Entity;

use AppBundle\Document\PlayerChance;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

class PlayerGame
{

    /**
     * Player 1 chances
     * @var PlayerChance
     * @JMS\Type("AppBundle\Document\PlayerChance")
     */
    protected $player1;

    /**
     * Player 2 chances
     * @var PlayerChance
     * @JMS\Type("AppBundle\Document\PlayerChance")
     */
    protected $player2;

    /**
     * Latest games between these two players
     * @var Game[]
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Game>")
     */
    protected $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * Gets the Player1
     * @return PlayerChance
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @param PlayerChance $player1
     *
     * @return PlayerGame
     */
    public function setPlayer1(PlayerChance $player1)
    {
        $this->player1 = $player1;

        return $this;
    }

    /**
     * Gets the Player2
     * @return PlayerChance
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * @param PlayerChance $player2
     *
     * @return PlayerGame
     */
    public function setPlayer2(PlayerChance $player2)
    {
        $this->player2 = $player2;

        return $this;
    }

    /**
     * Gets the Game
     * @return Game[]
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param Game $game
     *
     * @return PlayerGame
     */
    public function addGame(Game $game)
    {
        $this->games[] = $game;
        return $this;
    }

    /**
     * @param Game[] $games
     *
     * @return PlayerGame
     */
    public function setGames(array $games)
    {
        $this->games = [];
        foreach($games as $game) {
            $this->addGame($game);
        }

        return $this;
    }

}
