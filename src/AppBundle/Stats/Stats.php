<?php
namespace AppBundle\Stats;

use AppBundle\Document\Game\Stats as GameStats;
use AppBundle\Document\Player\Stats as PlayerStats;
use AppBundle\Document\AllStats;
use AppBundle\Document\SinglePlayer\Stats as SinglePlayerStats;
use AppBundle\Entity\Player;
use AppBundle\Stats\Game\GameStatsInterface;
use AppBundle\Stats\Player\PlayerStatsInterface;
use AppBundle\Stats\SinglePlayer\StatsInterface as SPStatsInterface;

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
     * @var SPStatsInterface[]
     */
    private $singlePlayerStats = [];

    /**
     * @param StatsInterface $stats
     */
    public function add(StatsInterface $stats)
    {

        if ($stats instanceof SPStatsInterface) {
            $this->singlePlayerStats[] = $stats;
        }

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
     * @param Player $player
     * @param SinglePlayerStats|null $stats
     * @return SinglePlayerStats
     */
    public function getSinglePlayerStats(Player $player, SinglePlayerStats $stats = null)
    {
        if ($stats === null) {
            $stats = new SinglePlayerStats();
            $stats->setData($player);
        }

        foreach($this->singlePlayerStats as $provider) {
            $provider->set($player, $stats);
        }

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
