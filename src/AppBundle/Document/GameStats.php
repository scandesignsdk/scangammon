<?php
namespace AppBundle\Document;

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
     * Total gammons
     * @var int
     * @JMS\Type("integer")
     * @JMS\SerializedName("Total gammons")
     */
    protected $totalGammon;

    /**
     * Total backgammons
     * @var int
     * @JMS\Type("integer")
     * @JMS\SerializedName("Total backgammons")
     */
    protected $totalBackGammon;

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

    /**
     * Gets the TotalGammon
     * @return int
     */
    public function getTotalGammon()
    {
        return $this->totalGammon;
    }

    /**
     * @param int $totalGammon
     *
     * @return GameStats
     */
    public function setTotalGammon($totalGammon)
    {
        $this->totalGammon = $totalGammon;

        return $this;
    }

    /**
     * Gets the TotalBackGammon
     * @return int
     */
    public function getTotalBackGammon()
    {
        return $this->totalBackGammon;
    }

    /**
     * @param int $totalBackGammon
     *
     * @return GameStats
     */
    public function setTotalBackGammon($totalBackGammon)
    {
        $this->totalBackGammon = $totalBackGammon;

        return $this;
    }

}
