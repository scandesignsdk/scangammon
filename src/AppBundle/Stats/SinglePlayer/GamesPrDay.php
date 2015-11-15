<?php
namespace AppBundle\Stats\SinglePlayer;

use AppBundle\Document\SinglePlayer\PlayerGamesPrDay;
use AppBundle\Document\SinglePlayer\Stats;
use AppBundle\Entity\Player;
use Doctrine\ORM\Query\ResultSetMapping;

class GamesPrDay extends AbstractStats
{

    public function set(Player $player, Stats $stats)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('counter', 'counter', 'integer');
        $rsm->addScalarResult('date', 'date', 'datetime');
        $sql = 'SELECT COUNT(*) as counter, date FROM game WHERE player1_id = :p1 OR player2_id = :p2 GROUP BY DAY(date)';

        $manager = $this->gameRepository->getManager();
        $nq = $manager->createNativeQuery($sql, $rsm);
        $results = $nq->execute([
            'p1' => $player->getId(),
            'p2' => $player->getId()
        ]);

        $out = [];
        foreach($results as $res) {
            $out[] = new PlayerGamesPrDay($res['counter'], $res['date']);
        }

        $stats->setGamesPrDay($out);

    }
}
