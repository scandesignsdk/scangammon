<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOS;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatsController extends BaseController
{

    /**
     * @FOS\Get()
     * @FOS\View()
     * @ApiDoc(
     *  section="stats",
     *  description="Get games stats",
     *  output="AppBundle\Document\GameStats"
     * )
     *
     * @return JsonResponse
     */
    public function getGamesAction()
    {
        $stats = $this->get('stats')->getGameStats();
        $view = $this->view($stats, 200);
        return $this->handleView($view);
    }

    /**
     * @FOS\Get()
     * @FOS\View()
     * @ApiDoc(
     *  section="stats",
     *  description="Get player stats",
     *  output="AppBundle\Document\PlayerStats"
     * )
     */
    public function getPlayersAction()
    {
        $stats = $this->get('stats')->getPlayerStats();
        $view = $this->view($stats, 200);
        return $this->handleView($view);
    }

    /**
     * @FOS\Get()
     * @FOS\View()
     * @ApiDoc(
     *  section="stats",
     *  description="Get both player and game stats",
     *  output="AppBundle\Document\AllStats"
     * )
     *
     * @return JsonResponse
     */
    public function getAllAction()
    {
        $stats = $this->get('stats')->getAll();
        $view = $this->view($stats, 200);
        return $this->handleView($view);
    }

}
