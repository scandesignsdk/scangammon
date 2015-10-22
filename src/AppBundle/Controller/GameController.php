<?php

namespace AppBundle\Controller;

use AppBundle\Event\Game\CreateEvent;
use AppBundle\Event\Game\DeleteEvent;
use AppBundle\Events;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameController extends BaseController
{

    /**
     * @FOS\Get()
     * @FOS\QueryParam(name="limit", requirements="\d+", description="Limit to how many games", default="10")
     * @ApiDoc(
     *  section="game",
     *  description="Get latest games",
     *  output="AppBundle\Entity\Game"
     * )
     *
     * @param ParamFetcher $params
     * @return JsonResponse
     */
    public function getAction(ParamFetcher $params)
    {
        $games = $this->get('game.service')->listGames($params->get('limit'));
        return new JsonResponse($this->get('serializer')->serialize($games, 'json'));
    }

    /**
     * @FOS\Get("players")
     * @FOS\QueryParam(name="p1", description="Player 1 ID", requirements="\d+")
     * @FOS\QueryParam(name="p2", description="Player 2 ID", requirements="\d+")
     * @FOS\QueryParam(name="limit", requirements="\d+", description="Limit to how many games", default="10")
     * @ApiDoc(
     *  section="game",
     *  description="Get latest games between 2 players",
     *  statusCodes={
     *      404={
     *          "Player 1 not found",
     *          "Player 2 not found"
     *      }
     *  },
     *  output="AppBundle\Entity\PlayerGame"
     * )
     *
     * @param ParamFetcher $params
     * @return JsonResponse
     */
    public function getPlayerGamesAction(ParamFetcher $params)
    {
        try {
            $games = $this->get('game.service')->listGamesByPlayers($params->get('p1'), $params->get('p2'), $params->get('limit'));
            return new JsonResponse($this->get('serializer')->serialize($games, 'json'));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 404);
        }
    }

    /**
     * @FOS\Post()
     * @FOS\RequestParam(name="p1", description="Player1 id", requirements="\d+")
     * @FOS\RequestParam(name="p2", description="Player2 id", requirements="\d+")
     * @FOS\RequestParam(name="winner", requirements="\d+", description="Winner - 1 for player 1, 2 for player 2")
     * @ApiDoc(
     *  section="game",
     *  description="Add game",
     *  statusCodes={
     *      200="Game created",
     *      404={
     *          "Player 1 not found",
     *          "Player 2 not found",
     *              "Winner not correct format"
     *      }
     *  }
     * )
     *
     * @param ParamFetcher $params
     * @return JsonResponse
     */
    public function addAction(ParamFetcher $params)
    {
        try {
            $game = $this->get('game.service')->createGame($params);
            $this->get('event_dispatcher')->dispatch(Events::GAME_CREATED, new CreateEvent($game));
            return new JsonResponse('Game created');
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 404);
        }
    }

    /**
     * @FOS\Delete()
     * @ApiDoc(
     *  section="game",
     *  description="Delete a game",
     *  statusCodes={
     *      200="Game deleted",
     *      404="Game not found"
     *  },
     * )
     *
     * @param int $id Game ID
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        try {
            $game = $this->get('game.service')->deleteGame($id);
            $this->get('event_dispatcher')->dispatch(Events::GAME_DELETED, new DeleteEvent($game));
            return new JsonResponse('Game deleted');
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 404);
        }

    }

}
