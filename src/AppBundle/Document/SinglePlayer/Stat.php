<?php
namespace AppBundle\Document\SinglePlayer;

use AppBundle\Entity\Player;
use JMS\Serializer\Annotation as JMS;

class Stat
{

    /**
     * Stat title
     * @var string
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * Stat value
     * @var integer
     * @JMS\Type("integer")
     */
    protected $value;

    /**
     * Stat percent
     * @var float
     * @JMS\Type("double")
     */
    protected $percent = null;

    /**
     * Player
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player = null;

    /**
     * @param string $title
     * @param integer $value
     * @param float|null $percent
     * @param Player|null $player
     */
    public function __construct($title, $value, $percent = null, Player $player = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->percent = $percent;
        $this->player = $player;
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get Value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get Percent
     *
     * @return float
     */
    public function getPercent()
    {
        return $this->percent;
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
