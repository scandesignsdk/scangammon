<?php
namespace AppBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

class PlayerStats
{

    /**
     * Player stat
     * @var PlayerStat[]|ArrayCollection
     * @JMS\Type("ArrayCollection<AppBundle\Document\PlayerStat>")
     */
    protected $stats;

    public function __construct()
    {
        $this->stats = new ArrayCollection();
    }

    /**
     * @param PlayerStat $stat
     * @return $this
     */
    public function addStat(PlayerStat $stat)
    {
        $this->stats->add($stat);
        return $this;
    }

    /**
     * @return PlayerStat[]|ArrayCollection
     */
    public function getStats()
    {
        return $this->stats;
    }

}
