<?php
namespace AppBundle\Document;

use AppBundle\Entity\Player;
use JMS\Serializer\Annotation as JMS;

class PlayerChance
{

    /**
     * Player
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player;

    /**
     * Chance to win
     * @var float
     * @JMS\Type("double")
     */
    protected $chance;

    /**
     * Elo if win
     * @var integer
     * @JMS\Type("integer")
     */
    protected $winNormal;

    /**
     * Elo if win with gammon
     * @var integer
     * @JMS\Type("integer")
     */
    protected $winGammon;

    /**
     * Elo if win with backgammon
     * @var integer
     * @JMS\Type("integer")
     */
    protected $winBackgammon;

    /**
     * Elo if lose
     * @var integer
     * @JMS\Type("integer")
     */
    protected $loseNormal;

    /**
     * Elo if lose with gammon
     * @var integer
     * @JMS\Type("integer")
     */
    protected $loseGammon;

    /**
     * Elo if lose with backgammon
     * @var integer
     * @JMS\Type("integer")
     */
    protected $loseBackgammon;

    /**
     * Gets the Player
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Player $player
     *
     * @return PlayerChance
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Gets the Chance
     * @return float
     */
    public function getChance()
    {
        return number_format($this->chance * 100, 1, '.', '');
    }

    /**
     * @param float $chance
     *
     * @return PlayerChance
     */
    public function setChance($chance)
    {
        $this->chance = $chance;

        return $this;
    }

    /**
     * Gets the WinNormal
     * @return int
     */
    public function getWinNormal()
    {
        return $this->winNormal;
    }

    /**
     * @param int $winNormal
     *
     * @return PlayerChance
     */
    public function setWinNormal($winNormal)
    {
        $this->winNormal = $winNormal;

        return $this;
    }

    /**
     * Gets the WinGammon
     * @return int
     */
    public function getWinGammon()
    {
        return $this->winGammon;
    }

    /**
     * @param int $winGammon
     *
     * @return PlayerChance
     */
    public function setWinGammon($winGammon)
    {
        $this->winGammon = $winGammon;

        return $this;
    }

    /**
     * Gets the WinBackgammon
     * @return int
     */
    public function getWinBackgammon()
    {
        return $this->winBackgammon;
    }

    /**
     * @param int $winBackgammon
     *
     * @return PlayerChance
     */
    public function setWinBackgammon($winBackgammon)
    {
        $this->winBackgammon = $winBackgammon;

        return $this;
    }

    /**
     * Gets the LoseNormal
     * @return int
     */
    public function getLoseNormal()
    {
        return $this->loseNormal;
    }

    /**
     * @param int $loseNormal
     *
     * @return PlayerChance
     */
    public function setLoseNormal($loseNormal)
    {
        $this->loseNormal = $loseNormal;

        return $this;
    }

    /**
     * Gets the LoseGammon
     * @return int
     */
    public function getLoseGammon()
    {
        return $this->loseGammon;
    }

    /**
     * @param int $loseGammon
     *
     * @return PlayerChance
     */
    public function setLoseGammon($loseGammon)
    {
        $this->loseGammon = $loseGammon;

        return $this;
    }

    /**
     * Gets the LoseBackgammon
     * @return int
     */
    public function getLoseBackgammon()
    {
        return $this->loseBackgammon;
    }

    /**
     * @param int $loseBackgammon
     *
     * @return PlayerChance
     */
    public function setLoseBackgammon($loseBackgammon)
    {
        $this->loseBackgammon = $loseBackgammon;

        return $this;
    }

}
