<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

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

    public function getManager()
    {
        return $this->_em;
    }

}
