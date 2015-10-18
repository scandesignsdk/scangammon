<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Event\Player\CreateEvent;
use AppBundle\Events;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PlayerController
 * @package AppBundle\Controller
 *
 * @FOS\NamePrefix("user")
 */
class PlayerController extends BaseController
{

    /**
     * @FOS\Get("get")
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
        return new JsonResponse($this->get('serializer')->serialize($players, 'json'));
    }

    /**
     * @FOS\Post("add")
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
            return new JsonResponse('Player created', 200);
        }

        return new JsonResponse('Player with same name already exists', 404);
    }

}
