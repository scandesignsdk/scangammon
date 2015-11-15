<?php
namespace AppBundle\Document\SinglePlayer;

use AppBundle\Entity\Player;
use JMS\Serializer\Annotation as JMS;

class AgainstPlayerWinRate
{

    /**
     * Number of wins
     * @var int
     * @JMS\Type("integer")
     */
    protected $wins;

    /**
     * Number of losses
     * @var int
     * @JMS\Type("integer")
     */
    protected $lost;

    /**
     * Opponent
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player;

    /**
     * @param int $wins
     * @param int $lost
     * @param Player $player
     */
    public function __construct($wins, $lost, Player $player)
    {
        $this->wins = $wins;
        $this->lost = $lost;
        $this->player = $player;
    }

    /**
     * Get Wins
     *
     * @return int
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Get Lost
     *
     * @return int
     */
    public function getLost()
    {
        return $this->lost;
    }

    /**
     * Get Player
     *
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

}
