<?php
namespace AppBundle\Service;

use AppBundle\Document\PlayerChance;
use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerGame;
use Jleagle\Elo\Elo;

class EloCalculator
{

    const GAMMON = 1.5;
    const BACKGAMMON = 2;

    /**
     * @param Player $p1
     * @param Player $p2
     *
     * @return PlayerGame
     */
    public function getPlayerstats(Player $p1, Player $p2)
    {
        $elo = new Elo($p1->getElo(), $p2->getElo(), 1, 0);
        $expected = $elo->getExpected();
        $player1win = $elo->getRatings();

        $elo = new Elo($p1->getElo(), $p2->getElo(), 0, 1);
        $player2win = $elo->getRatings();

        $chance1 = new PlayerChance();
        $chance1->setPlayer($p1)
            ->setChance($expected['a'] * 100)
            ->setWinNormal($player1win['a'])
            ->setWinGammon($this->calculateGammon($p1->getElo(), $player1win['a'], self::GAMMON))
            ->setWinBackgammon($this->calculateGammon($p1->getElo(), $player1win['a'], self::BACKGAMMON))
            ->setLoseNormal($player2win['a'])
            ->setLoseGammon($this->calculateGammon($p1->getElo(), $player2win['a'], self::GAMMON))
            ->setLoseBackgammon($this->calculateGammon($p1->getElo(), $player2win['a'], self::BACKGAMMON))
        ;

        $chance2 = new PlayerChance();
        $chance2->setPlayer($p2)
            ->setChance($expected['b'] * 100)
            ->setWinNormal($player2win['b'])
            ->setWinGammon($this->calculateGammon($p2->getElo(), $player2win['b'], self::GAMMON))
            ->setWinBackgammon($this->calculateGammon($p2->getElo(), $player2win['b'], self::BACKGAMMON))
            ->setLoseNormal($player1win['b'])
            ->setLoseGammon($this->calculateGammon($p2->getElo(), $player1win['b'], self::GAMMON))
            ->setLoseBackgammon($this->calculateGammon($p2->getElo(), $player1win['b'], self::BACKGAMMON))

        ;

        $data = new PlayerGame();
        $data->setPlayer1($chance1)
            ->setPlayer2($chance2)
        ;

        return $data;
    }

    public function getNewElo(Player $p1, Player $p2, $winner, $wintype)
    {
        $stats = $this->getPlayerstats($p1, $p2);
        switch ($wintype) {
            default:
            case Game::WINTYPE_NORMAL:
                if ($winner == Game::P1WINNER) {
                    $p1Elo = $stats->getPlayer1()->getWinNormal();
                    $p2Elo = $stats->getPlayer2()->getLoseNormal();
                } else {
                    $p1Elo = $stats->getPlayer1()->getLoseNormal();
                    $p2Elo = $stats->getPlayer2()->getWinNormal();
                }
                break;
            case Game::WINTYPE_GAMMON:
                if ($winner == Game::P1WINNER) {
                    $p1Elo = $stats->getPlayer1()->getWinGammon();
                    $p2Elo = $stats->getPlayer2()->getLoseGammon();
                } else {
                    $p1Elo = $stats->getPlayer1()->getLoseGammon();
                    $p2Elo = $stats->getPlayer2()->getWinGammon();
                }
                break;
            case Game::WINTYPE_BACKGAMMON:
                if ($winner == Game::P1WINNER) {
                    $p1Elo = $stats->getPlayer1()->getWinBackgammon();
                    $p2Elo = $stats->getPlayer2()->getLoseBackgammon();
                } else {
                    $p1Elo = $stats->getPlayer1()->getLoseBackgammon();
                    $p2Elo = $stats->getPlayer2()->getWinBackgammon();
                }
                break;
        }

        return [$p1Elo, $p2Elo];
    }

    /**
     * @param int $startElo
     * @param int $nextElo
     * @param int $multiplier
     *
     * @return int
     */
    private function calculateGammon($startElo, $nextElo, $multiplier)
    {
        if ($nextElo > $startElo) {
            return ceil($startElo + (($nextElo - $startElo) * $multiplier));
        }

        return ceil($startElo + (($nextElo - $startElo) * $multiplier));
    }

}
