<?php
namespace AppBundle\Stats;

use AppBundle\Document\AllStats;
use AppBundle\Document\GameStats;
use AppBundle\Document\PlayerStats;
use AppBundle\Stats\Game\GameStatsInterface;
use AppBundle\Stats\Player\PlayerStatsInterface;

class Stats
{

    /**
     * @var GameStatsInterface[]
     */
    private $gameStats = [];

    /**
     * @var PlayerStatsInterface[]
     */
    private $playerStats = [];

    /**
     * @param StatsInterface $stats
     */
    public function add(StatsInterface $stats)
    {

        if ($stats instanceof GameStatsInterface) {
            $this->gameStats[] = $stats;
        }

        if ($stats instanceof PlayerStatsInterface) {
            $this->playerStats[] = $stats;
        }

    }

    /**
     * @param AllStats $stats
     * @return AllStats
     */
    public function getAll(AllStats $stats = null)
    {
        if ($stats === null) {
            $stats = new AllStats();
        }

        $stats->setGame($this->getGameStats());
        $stats->setPlayer($this->getPlayerStats());
        return $stats;
    }

    /**
     * @param GameStats $stats
     * @return GameStats
     */
    public function getGameStats(GameStats $stats = null)
    {
        if ($stats === null) {
            $stats = new GameStats();
        }

        foreach($this->gameStats as $statsProvider) {
            $statsProvider->set($stats);
        }
        return $stats;
    }

    /**
     * @param PlayerStats $stats
     * @return PlayerStats
     */
    public function getPlayerStats(PlayerStats $stats = null)
    {
        if ($stats === null) {
            $stats = new PlayerStats();
        }

        foreach($this->playerStats as $statsProvider) {
            $statsProvider->set($stats);
        }
        return $stats;
    }

}
