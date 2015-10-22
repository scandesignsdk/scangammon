<?php
namespace AppBundle\Document;

use AppBundle\Entity\Player;
use JMS\Serializer\Annotation as JMS;

class PlayerStats
{

    /**
     * Total players
     * @var int
     * @JMS\Type("integer")
     * @JMS\SerializedName("Total players")
     */
    protected $total;

    /**
     * Player with most games
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     * @JMS\SerializedName("[PLAYER] Player with most games")
     */
    protected $mostPlayedPlayer;

    /**
     * Highest ranked player
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     * @JMS\SerializedName("[PLAYER] Highest ranked player")
     */
    protected $highestRanked;

    /**
     * Lowest ranked player
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     * @JMS\SerializedName("[PLAYER] Lowest ranked player")
     */
    protected $lowestRanked;

    /**
     * Average elo ranking
     * @var int
     * @JMS\Type("integer")
     * @JMS\SerializedName("Average elo rank")
     */
    protected $avgElo;

    /**
     * Get Total
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set Total
     *
     * @param int $total
     * @return PlayerStats
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Get MostPlayed
     *
     * @return int
     */
    public function getMostPlayed()
    {
        return $this->mostPlayed;
    }

    /**
     * Set MostPlayed
     *
     * @param int $mostPlayed
     * @return PlayerStats
     */
    public function setMostPlayed($mostPlayed)
    {
        $this->mostPlayed = $mostPlayed;
        return $this;
    }

    /**
     * Get MostPlayedPlayer
     *
     * @return Player
     */
    public function getMostPlayedPlayer()
    {
        return $this->mostPlayedPlayer;
    }

    /**
     * Set MostPlayedPlayer
     *
     * @param Player $mostPlayedPlayer
     * @return PlayerStats
     */
    public function setMostPlayedPlayer(Player $mostPlayedPlayer)
    {
        $this->mostPlayedPlayer = $mostPlayedPlayer;
        return $this;
    }

    /**
     * Get HighestRanked
     *
     * @return Player
     */
    public function getHighestRanked()
    {
        return $this->highestRanked;
    }

    /**
     * Set HighestRanked
     *
     * @param Player $highestRanked
     * @return PlayerStats
     */
    public function setHighestRanked(Player $highestRanked)
    {
        $this->highestRanked = $highestRanked;
        return $this;
    }

    /**
     * Get LowestRanked
     *
     * @return Player
     */
    public function getLowestRanked()
    {
        return $this->lowestRanked;
    }

    /**
     * Set LowestRanked
     *
     * @param Player $lowestRanked
     * @return PlayerStats
     */
    public function setLowestRanked(Player $lowestRanked)
    {
        $this->lowestRanked = $lowestRanked;
        return $this;
    }

    /**
     * Get AvgElo
     *
     * @return int
     */
    public function getAvgElo()
    {
        return $this->avgElo;
    }

    /**
     * Set AvgElo
     *
     * @param int $avgElo
     * @return PlayerStats
     */
    public function setAvgElo($avgElo)
    {
        $this->avgElo = $avgElo;
        return $this;
    }

}
