<?php
namespace AppBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

class GameStats
{

    /**
     * Game stats
     * @var GameStat[]|ArrayCollection
     * @JMS\Type("ArrayCollection<AppBundle\Document\GameStat>")
     */
    protected $stats;

    public function __construct()
    {
        $this->stats = new ArrayCollection();
    }

    /**
     * @param GameStat $stat
     * @return $this
     */
    public function addStat(GameStat $stat)
    {
        $this->stats->add($stat);
        return $this;
    }

    /**
     * @return GameStat[]|ArrayCollection
     */
    public function getStats()
    {
        return $this->stats;
    }

}
