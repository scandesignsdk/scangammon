<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * GameRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class GameRepository extends EntityRepository
{

    /**
     * @param Player $p1
     * @param Player $p2
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByPlayers(Player $p1, Player $p2)
    {
        $builder = $this->createQueryBuilder('game');
        $builder->where(
            $builder->expr()->orX(
                $builder->expr()->eq('game.player1', $p1->getId()),
                $builder->expr()->eq('game.player2', $p1->getId())
            ),
            $builder->expr()->orX(
                $builder->expr()->eq('game.player1', $p2->getId()),
                $builder->expr()->eq('game.player2', $p2->getId())
            )
        );
        return $builder;
    }

    /**
     * @return array
     */
    public function findLeastGamesByPlayer()
    {
        $results = [];
        $this->findByPlayerGames(1, $results);
        $this->findByPlayerGames(2, $results);
        asort($results);

        $value = reset($results);
        $key = key($results);

        return ['player' => $key, 'numgames' => $value];
    }

    /**
     * @return array
     */
    public function findMostGamesByPlayer()
    {
        $results = [];
        $this->findByPlayerGames(1, $results);
        $this->findByPlayerGames(2, $results);
        arsort($results);

        $value = reset($results);
        $key = key($results);

        return ['player' => $key, 'numgames' => $value];
    }

    private function findByPlayerGames($player = 1, &$output = array())
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('COUNT(id)', 'numgames', 'integer');
        $rsm->addScalarResult('id', 'id', 'integer');
        $query = sprintf(
            'SELECT COUNT(id), player%d_id as id FROM game GROUP BY player%d_id ORDER BY COUNT(id) DESC',
            $player,
            $player
        );

        $q = $this->_em->createNativeQuery($query, $rsm);
        $results = $q->getResult();
        foreach($results as $res) {
            if (array_key_exists($res['id'], $output)) {
                $output[$res['id']] += $res['numgames'];
            } else {
                $output[$res['id']] = $res['numgames'];
            }
        }
    }

    public function getManager()
    {
        return $this->_em;
    }

    /**
     * @param int $playerId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByPlayer($playerId)
    {
        $builder = $this->createQueryBuilder('game');
        $builder->where(
            $builder->expr()->orX(
                $builder->expr()->eq('game.player1', $playerId),
                $builder->expr()->eq('game.player2', $playerId)
            )
        );
        return $builder;
    }

}
