<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\AgainstPlayerWinRate;
use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use Doctrine\ORM\Query\ResultSetMapping;

class WinRate extends AbstractStats
{

    public function set(Player $player, Stats $stats)
    {
        $players = $this->loadPlayers();

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('player1_id', 'p1', 'integer');
        $rsm->addScalarResult('player2_id', 'p2', 'integer');
        $rsm->addScalarResult('winner', 'winner', 'integer');

        $sql = 'SELECT player1_id, player2_id, winner FROM game WHERE player1_id = :p1 OR player2_id = :p2';
        $nsql = $this->gameRepository->getManager()->createNativeQuery($sql, $rsm);
        $nsql->setParameter(':p1', $player->getId(), 'integer');
        $nsql->setParameter(':p2', $player->getId(), 'integer');
        $results = $nsql->execute();

        $matches = [];
        foreach($results as $result) {
            $this->addResult($player, $result, $matches);
        }

        foreach($matches as $opponent => $result) {
            $stats->addAgainst(new AgainstPlayerWinRate($result['wins'], $result['lost'], $players[$opponent]));
        }
    }

    private function addResult(Player $player, array $result, array &$matches)
    {
        if ($result['p1'] == $player->getId()) {
            $this->setMatch($matches, $result, 'p2', Game::P1WINNER);
        } else {
            $this->setMatch($matches, $result, 'p1', Game::P2WINNER);
        }
    }

    private function setMatch(array &$matches, array $result, $type, $winner)
    {
        if (! isset($matches[$result[$type]])) {
            $matches[$result[$type]]['wins'] = 0;
            $matches[$result[$type]]['lost'] = 0;
        }

        if ($result['winner'] == $winner) {
            $matches[$result[$type]]['wins'] += 1;
        } else {
            $matches[$result[$type]]['lost'] += 1;
        }
    }

    /**
     * @return Player[]
     */
    private function loadPlayers()
    {
        $players = [];
        /** @var Player[] $plist */
        $plist = $this->playerRepository->findAll();
        foreach($plist as $p) {
            $players[$p->getId()] = $p;
        }
        return $players;
    }
}
