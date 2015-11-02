<?php

namespace AppBundle\Controller;

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
 * @FOS\NamePrefix("player")
 */
class PlayerController extends BaseController
{

    /**
     * @FOS\Get("")
     * @ApiDoc(
     *  section="player",
     *  description="Get players",
     *  output="AppBundle\Entity\Player"
     * )
     *
     * @return JsonResponse
     */
    public function getPlayersAction()
    {
        $players = $this->getPlayerRepo()->findBy([], ['name' => 'ASC']);
        return new JsonResponse($this->get('serializer')->serialize($players, 'json'));
    }

    /**
     * @FOS\Get()
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
            return new JsonResponse($this->get('serializer')->serialize($single, 'json'));
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(sprintf('Player with ID "%s" not found', $slug), 404);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    /**
     * @FOS\Post()
     * @FOS\RequestParam(name="name", description="Player name")
     * @ApiDoc(
     *  section="player",
     *  description="Add a new player",
     *  statusCodes={
     *      200="Player created",
     *      404="Player with same name already exists",
     *      500="Some other error"
     *  }
     * )
     *
     * @param ParamFetcher $params
     * @return JsonResponse
     */
    public function addAction(ParamFetcher $params)
    {
        try {
            $this->get('player.service')->addPlayer($params->get('name'));
            $this->get('event_dispatcher')->dispatch(Events::PLAYER_CREATE, new CreateEvent($player));
            return new JsonResponse('Player created', 200);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse('Player with same name already exists', 404);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

}
