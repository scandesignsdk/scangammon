<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

class SinglePlayer
{

    /**
     * Player data
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $data;

    /**
     * Games
     * @var Game[]|ArrayCollection
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Game>")
     */
    protected $games;

    /**
     * Games pr day
     * @var SinglePlayerGamesPrDay
     * @JMS\Type("ArrayCollection<AppBundle\Entity\SinglePlayerGamesPrDay>")
     */
    protected $gamesPrDay;

    /**
     * Total games played
     * @var int
     * @JMS\Type("integer")
     */
    protected $totalGames;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->gamesPrDay = new ArrayCollection();
    }

    /**
     * Get Data
     *
     * @return Player
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data
     *
     * @param Player $data
     * @return SinglePlayer
     */
    public function setData(Player $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get Games
     *
     * @return Game[]
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Add game
     *
     * @param Game $game
     * @return $this
     */
    public function addGame(Game $game)
    {
        $this->games->add($game);
        return $this;
    }

    /**
     * Set Games
     *
     * @param Game[] $games
     * @return SinglePlayer
     */
    public function setGames(array $games = null)
    {
        $this->games = new ArrayCollection();
        if ($games) {
            foreach($games as $game) {
                $this->addGame($game);
            }
        }
        return $this;
    }

    /**
     * Get AvgGamesDay
     *
     * @return SinglePlayerGamesPrDay
     */
    public function getGamesPrDay()
    {
        return $this->gamesPrDay;
    }

    /**
     * Add games pr day
     *
     * @param SinglePlayerGamesPrDay $day
     * @return $this
     */
    public function addGamesPrDay(SinglePlayerGamesPrDay $day)
    {
        $this->gamesPrDay->add($day);
        return $this;
    }

    /**
     * Set AvgGamesDay
     *
     * @param array $gamesPrDay
     * @return SinglePlayer
     */
    public function setGamesPrDay(array $gamesPrDay = null)
    {
        $this->gamesPrDay = new ArrayCollection();
        if ($gamesPrDay) {
            foreach($gamesPrDay as $avg) {
                $this->addGamesPrDay($avg);
            }
        }
        return $this;
    }

    /**
     * Get TotalGames
     *
     * @return int
     */
    public function getTotalGames()
    {
        return $this->totalGames;
    }

    /**
     * Set TotalGames
     *
     * @param int $totalGames
     * @return SinglePlayer
     */
    public function setTotalGames($totalGames)
    {
        $this->totalGames = $totalGames;
        return $this;
    }

}
