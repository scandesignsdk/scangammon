<?php
namespace AppBundle\Document;

use AppBundle\Entity\Player;
use JMS\Serializer\Annotation as JMS;

class PlayerStat
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
     * Player
     * @var Player
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player;

    /**
     * If the stat has player
     * @var bool
     * @JMS\Type("boolean")
     */
    protected $hasPlayer = false;

    public function __construct($title, $value, Player $player = null)
    {
        $this->title = $title;
        $this->value = $value;

        $this->player = $player;
        if ($player != null) {
            $this->hasPlayer = true;
        }

    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return boolean
     */
    public function isHasPlayer()
    {
        return $this->hasPlayer;
    }


}
