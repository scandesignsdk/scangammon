<?php
namespace AppBundle\Document\Game;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

class Stats
{

    /**
     * Game stats
     * @var Stat[]|ArrayCollection
     * @JMS\Type("ArrayCollection<AppBundle\Document\Game\Stat>")
     */
    protected $stats;

    public function __construct()
    {
        $this->stats = new ArrayCollection();
    }

    /**
     * @param Stat $stat
     * @return $this
     */
    public function addStat(Stat $stat)
    {
        $this->stats->add($stat);
        return $this;
    }

    /**
     * @return Stat[]|ArrayCollection
     */
    public function getStats()
    {
        return $this->stats;
    }

}
