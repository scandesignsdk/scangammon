<?php
namespace AppBundle\Document\Game;

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
    protected $percent;

    /**
     * If the stat has percent
     * @var bool
     * @JMS\Type("boolean")
     */
    protected $hasPercent = false;

    public function __construct($title, $value, $percent = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->percent = $percent;
        if ($percent !== null) {
            $this->hasPercent = true;
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
     * @return float
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * @return boolean
     */
    public function isHasPercent()
    {
        return $this->hasPercent;
    }

}
