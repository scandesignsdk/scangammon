<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Event\Player\CreateEvent;
use AppBundle\Events;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PlayerController
 * @package AppBundle\Controller
 *
 * @FOS\NamePrefix("user")
 */
class PlayerController extends BaseController
{

    /**
     * @FOS\Get()
     * @FOS\View()
     * @ApiDoc(
     *  section="user",
     *  description="Get players",
     *  output="AppBundle\Entity\Player"
     * )
     *
     * @return JsonResponse
     */
    public function getAction()
    {
        $players = $this->getPlayerRepo()->findBy([], ['name' => 'ASC']);
        $view = $this->view($players);
        return $this->handleView($view);
    }

    /**
     * @FOS\Get()
     * @FOS\View()
     * @ApiDoc(
     *  section="player",
     *  description="Get player data",
     *  output="AppBundle\Entity\SinglePlayer",
     *  statusCodes={
     *      404 = "Player not found"
     *  }
     * )
     * @param string $slug
     * @return JsonResponse
     */
    public function cgetAction($slug)
    {
        try {
            $single = $this->get('player.service')->singlePlayer($slug);
            $view = $this->view($single, 200);
        } catch (\InvalidArgumentException $e) {
            $view = $this->view(sprintf('Player "%s" not found', $slug), 404);
        } catch (\Exception $e) {
            $view = $this->view($e->getMessage(), 500);
        }

        return $this->handleView($view);
    }

    /**
     * @FOS\Post()
     * @FOS\View()
     * @FOS\RequestParam(name="name", description="Player name")
     * @ApiDoc(
     *  section="user",
     *  description="Add a new player",
     *  statusCodes={
     *      200="Player created",
     *      404="Player with same name already exists",
     *  }
     * )
     *
     * @param ParamFetcher $params
     * @return JsonResponse
     */
    public function addAction(ParamFetcher $params)
    {
        $player = $this->getPlayerRepo()->findOneBy(['name' => $params->get('name')]);
        if (! $player) {
            $player = new Player();
            $player->setName($params->get('name'));
            $this->save($player);

            $this->get('event_dispatcher')->dispatch(Events::PLAYER_CREATE, new CreateEvent($player));
            $view = $this->view('Player created', 200);
        } else {
            $view = $this->view('Player with same name already exists', 404);
        }

        return $this->handleView($view);
    }

}
