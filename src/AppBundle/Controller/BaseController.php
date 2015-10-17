<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

abstract class BaseController extends FOSRestController
{

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getManager()
    {
        return $this->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @return \AppBundle\Entity\PlayerRepository
     */
    protected function getPlayerRepo()
    {
        return $this->get('repo.player');
    }

    /**
     * @return \AppBundle\Entity\GameRepository
     */
    protected function getGameRepo()
    {
        return $this->get('repo.game');
    }

    /**
     * @param object $obj
     * @param bool $flush
     */
    protected function save($obj, $flush = true)
    {
        try {
            $this->getManager()->persist($obj);
            if ($flush) {
                $this->getManager()->flush();
            }
        } catch (\Exception $e) {}
    }

}
