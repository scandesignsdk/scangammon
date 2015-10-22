<?php
namespace AppBundle\Document;

use AppBundle\Entity\Game;
use JMS\Serializer\Annotation as JMS;

class GameStats
{

    /**
     * Total played games
     * @var int
     * @JMS\Type("integer")
     * @JMS\SerializedName("Total games played")
     */
    protected $total;

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

}
