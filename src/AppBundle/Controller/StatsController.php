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
     *  description="Get total games played",
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
     *  description="Get total players",
     *  output="AppBundle\Document\PlayerStats"
     * )
     *
     * @return JsonResponse
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
     *  description="Get all stats",
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
