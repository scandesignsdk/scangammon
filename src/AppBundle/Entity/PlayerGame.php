<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

class PlayerGame
{

    /**
     * Player 1 data
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player1;

    /**
     * Player 1 win chance
     * @var float
     * @JMS\Type("double")
     */
    protected $player1WinChance;

    /**
     * Player 1 elo, if winner
     * @var int
     * @JMS\Type("integer")
     */
    protected $player1EloWin;

    /**
     * Player 1 elo, if loser
     * @var int
     * @JMS\Type("integer")
     */
    protected $player1EloLose;

    /**
     * Player 2 data
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player2;

    /**
     * Player 1 win chance
     * @var float
     * @JMS\Type("double")
     */
    protected $player2WinChance;

    /**
     * Player 2 elo, if winner
     * @var int
     * @JMS\Type("integer")
     */
    protected $player2EloWin;

    /**
     * Player 2 elo, if loser
     * @var int
     * @JMS\Type("integer")
     */
    protected $player2EloLose;

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
     * @return Player
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @param Player $player1
     *
     * @return PlayerGame
     */
    public function setPlayer1(Player $player1)
    {
        $this->player1 = $player1;

        return $this;
    }

    /**
     * Gets the Player2
     * @return Player
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * @param Player $player2
     *
     * @return PlayerGame
     */
    public function setPlayer2(Player $player2)
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

    /**
     * Gets the Player1WinChance
     * @return float
     */
    public function getPlayer1WinChance()
    {
        return $this->player1WinChance;
    }

    /**
     * @param float $player1WinChance
     *
     * @return PlayerGame
     */
    public function setPlayer1WinChance($player1WinChance)
    {
        $this->player1WinChance = $player1WinChance;

        return $this;
    }

    /**
     * Gets the Player1EloWin
     * @return int
     */
    public function getPlayer1EloWin()
    {
        return $this->player1EloWin;
    }

    /**
     * @param int $player1EloWin
     *
     * @return PlayerGame
     */
    public function setPlayer1EloWin($player1EloWin)
    {
        $this->player1EloWin = $player1EloWin;

        return $this;
    }

    /**
     * Gets the Player1EloLose
     * @return int
     */
    public function getPlayer1EloLose()
    {
        return $this->player1EloLose;
    }

    /**
     * @param int $player1EloLose
     *
     * @return PlayerGame
     */
    public function setPlayer1EloLose($player1EloLose)
    {
        $this->player1EloLose = $player1EloLose;

        return $this;
    }

    /**
     * Gets the Player2WinChance
     * @return float
     */
    public function getPlayer2WinChance()
    {
        return $this->player2WinChance;
    }

    /**
     * @param float $player2WinChance
     *
     * @return PlayerGame
     */
    public function setPlayer2WinChance($player2WinChance)
    {
        $this->player2WinChance = $player2WinChance;

        return $this;
    }

    /**
     * Gets the Player2EloWin
     * @return int
     */
    public function getPlayer2EloWin()
    {
        return $this->player2EloWin;
    }

    /**
     * @param int $player2EloWin
     *
     * @return PlayerGame
     */
    public function setPlayer2EloWin($player2EloWin)
    {
        $this->player2EloWin = $player2EloWin;

        return $this;
    }

    /**
     * Gets the Player2EloLose
     * @return int
     */
    public function getPlayer2EloLose()
    {
        return $this->player2EloLose;
    }

    /**
     * @param int $player2EloLose
     *
     * @return PlayerGame
     */
    public function setPlayer2EloLose($player2EloLose)
    {
        $this->player2EloLose = $player2EloLose;

        return $this;
    }

}
