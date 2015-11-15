<?php
namespace AppBundle\Document\SinglePlayer;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

class Stats
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
     * @var PlayerGamesPrDay
     * @JMS\Type("ArrayCollection<AppBundle\Document\SinglePlayer\PlayerGamesPrDay>")
     */
    protected $gamesPrDay;

    /**
     * Opponents matches
     * @var AgainstPlayerWinRate[]|ArrayCollection
     * @JMS\Type("ArrayCollection<AppBundle\Document\SinglePlayer\AgainstPlayerWinRate>")
     */
    protected $against;

    /**
     * Stats
     * @var Stat[]|ArrayCollection
     * @JMS\Type("ArrayCollection<AppBundle\Document\SinglePlayer\Stat>")
     */
    protected $stats;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->gamesPrDay = new ArrayCollection();
        $this->stats = new ArrayCollection();
        $this->against = new ArrayCollection();
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
     * @return Stats
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
     * @return Stats
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
     * @return PlayerGamesPrDay
     */
    public function getGamesPrDay()
    {
        return $this->gamesPrDay;
    }

    /**
     * Add games pr day
     *
     * @param PlayerGamesPrDay $day
     * @return $this
     */
    public function addGamesPrDay(PlayerGamesPrDay $day)
    {
        $this->gamesPrDay->add($day);
        return $this;
    }

    /**
     * Set AvgGamesDay
     *
     * @param array $gamesPrDay
     * @return Stats
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
     * Get Stats
     *
     * @return Stat[]|ArrayCollection
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * Add stat
     *
     * @param Stat $stat
     * @return $this
     */
    public function addStat(Stat $stat)
    {
        $this->stats->add($stat);
        return $this;
    }

    /**
     * Set Stats
     *
     * @param Stat[]|ArrayCollection $stats
     * @return Stats
     */
    public function setStats(array $stats = null)
    {
        $this->stats = new ArrayCollection();
        if ($stats) {
            foreach($stats as $stat) {
                $this->addStat($stat);
            }
        }
        return $this;
    }

    /**
     * Get Against
     *
     * @return AgainstPlayerWinRate[]|ArrayCollection
     */
    public function getAgainst()
    {
        return $this->against;
    }

    /**
     * Set Against
     *
     * @param AgainstPlayerWinRate[]|ArrayCollection $against
     * @return Stats
     */
    public function setAgainst(array $against = null)
    {
        $this->against = new ArrayCollection();
        if ($against) {
            foreach($against as $a) {
                $this->addAgainst($a);
            }
        }

        return $this;
    }

    /**
     * Add against
     *
     * @param AgainstPlayerWinRate $against
     * @return Stats
     */
    public function addAgainst(AgainstPlayerWinRate $against)
    {
        $this->against->add($against);
        return $this;
    }
}
