<?php
namespace AppBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class SinglePlayerGamesPrDay
{

    /**
     * Games
     * @var int
     * @JMS\Type("integer")
     */
    protected $count;

    /**
     * Date
     * @var \DateTime
     * @JMS\Type("DateTime<'Y-m-d'>")
     */
    protected $date;

    /**
     * @param null $count
     * @param \DateTime|null $date
     */
    public function __construct($count = null, \DateTime $date = null)
    {
        $this->count = $count;
        $this->date = $date;
    }

    /**
     * Get Count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set Count
     *
     * @param int $count
     * @return SinglePlayerGamesPrDay
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Get Date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set Date
     *
     * @param \DateTime $date
     * @return SinglePlayerGamesPrDay
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

}
