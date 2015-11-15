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
     * Has percent
     * @var bool
     * @JMS\Type("boolean")
     */
    protected $has_percent = false;

    /**
     * Player
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player = null;

    /**
     * Has player
     * @var bool
     * @JMS\Type("boolean")
     */
    protected $has_player = false;

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
        if ($this->percent !== null) {
            $this->has_percent = true;
        }

        $this->player = $player;
        if ($this->player !== null) {
            $this->has_player = true;
        }
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
