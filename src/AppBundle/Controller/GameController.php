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
     * @FOS\View()
     * @FOS\QueryParam(name="limit", requirements="\d+", description="Limit to how many games", default="10")
     * @FOS\QueryParam(name="page", requirements="\d+", description="Paging", default="1")
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
        $games = $this->get('game.service')->listGames($params->get('limit'), $params->get('page'));
        $view = $this->view($games, 200);
        return $this->handleView($view);
    }

    /**
     * @FOS\Get("players")
     * @FOS\View()
     * @FOS\QueryParam(name="p1", description="Player 1 ID", requirements="\d+")
     * @FOS\QueryParam(name="p2", description="Player 2 ID", requirements="\d+")
     * @FOS\QueryParam(name="limit", requirements="\d+", description="Limit to how many games", default="10")
     * @FOS\QueryParam(name="page", requirements="\d+", description="Paging", default="1")
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
            $games = $this->get('game.service')->listGamesByPlayers(
                $params->get('p1'),
                $params->get('p2'),
                $params->get('limit'),
                $params->get('page')
            );
            $view = $this->view($games, 200);
        } catch (\Exception $e) {
            $view = $this->view($e->getMessage(), 404);
        }
        return $this->handleView($view);
    }

    /**
     * @FOS\Post()
     * @FOS\View()
     * @FOS\RequestParam(name="p1", description="Player1 id", requirements="\d+")
     * @FOS\RequestParam(name="p2", description="Player2 id", requirements="\d+")
     * @FOS\RequestParam(name="winner", requirements="\d+", description="Winner - 1 for player 1, 2 for player 2")
     * @FOS\RequestParam(name="wintype", requirements="\d+", description="Wintype 0 = Normal, 1 = Gammon, 2 = Backgammon", default="0")
     * @ApiDoc(
     *  section="game",
     *  description="Add game",
     *  statusCodes={
     *      200="Game created",
     *      404={
     *          "Player 1 not found",
     *          "Player 2 not found",
     *          "Winner not correct format",
     *          "Wintype not correct format",
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
            $view = $this->view($game, 200);
        } catch (\Exception $e) {
            $view = $this->view($e->getMessage(), 404);
        }
        return $this->handleView($view);
    }

    /**
     * @FOS\Post("addByRFID")
     * @FOS\View()
     * @FOS\RequestParam(name="p1", description="Player1 RFID tag", requirements="\s+")
     * @FOS\RequestParam(name="p2", description="Player2 RFID tag", requirements="\s+")
     * @FOS\RequestParam(name="winner", requirements="\d+", description="Winner - 1 for player 1, 2 for player 2")
     * @FOS\RequestParam(name="wintype", requirements="\d+", description="Wintype 0 = Normal, 1 = Gammon, 2 = Backgammon", default="0")
     * @ApiDoc(
     *  section="game",
     *  description="Add game by RFID tags",
     *  statusCodes={
     *      200="Game created",
     *      404={
     *          "Player 1 not found",
     *          "Player 2 not found",
     *          "Winner not correct format",
     *          "Wintype not correct format",
     *      }
     *  }
     * )
     *
     * @param ParamFetcher $params
     * @return JsonResponse
     */
    public function addByRFIDAction(ParamFetcher $params)
    {
        try {
            $game = $this->get('game.service')->createGameByRFID($params);
            $this->get('event_dispatcher')->dispatch(Events::GAME_CREATED, new CreateEvent($game));
            $view = $this->view($game, 200);
        } catch (\Exception $e) {
            $view = $this->view($e->getMessage(), 404);
        }
        return $this->handleView($view);
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
            $view = $this->view('Game deleted', 200);
        } catch (\Exception $e) {
            $view = $this->view($e->getMessage(), 404);
        }
        return $this->handleView($view);
    }

}
