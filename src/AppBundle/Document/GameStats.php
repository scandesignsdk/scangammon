<?php
namespace AppBundle\Document;

use AppBundle\Entity\Game;
use JMS\Serializer\Annotation as JMS;

class GameStats
{

    /**
     * @var int
     * @JMS\Type("integer")
     * @JMS\SerializedName("Total games played")
     */
    protected $total;

    /**
     * @var Game
     * @JMS\Type("AppBundle\Entity\Game")
     * @JMS\SerializedName("[GAME] Game with highest elo change")
     */
    protected $higestEloChange;

    /**
     * @var Game
     * @JMS\Type("AppBundle\Entity\Game")
     * @JMS\SerializedName("[GAME] Game with lowest elo change")
     */
    protected $lowestEloChange;

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
     * @return GameStats
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Get HigestEloChange
     *
     * @return Game
     */
    public function getHigestEloChange()
    {
        return $this->higestEloChange;
    }

    /**
     * Set HigestEloChange
     *
     * @param Game $higestEloChange
     * @return GameStats
     */
    public function setHigestEloChange(Game $higestEloChange)
    {
        $this->higestEloChange = $higestEloChange;
        return $this;
    }

    /**
     * Get LowestEloChange
     *
     * @return Game
     */
    public function getLowestEloChange()
    {
        return $this->lowestEloChange;
    }

    /**
     * Set LowestEloChange
     *
     * @param Game $lowestEloChange
     * @return GameStats
     */
    public function setLowestEloChange(Game $lowestEloChange)
    {
        $this->lowestEloChange = $lowestEloChange;
        return $this;
    }

}
