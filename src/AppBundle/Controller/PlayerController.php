<?php

namespace AppBundle\Controller;

use AppBundle\Event\Player\CreateEvent;
use AppBundle\Events;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class PlayerController
 * @package AppBundle\Controller
 *
 * @FOS\NamePrefix("user")
 */
class PlayerController extends BaseController
{

    /**
     * @FOS\Get("")
     * @FOS\View()
     * @ApiDoc(
     *  section="user",
     *  description="Get players",
     *  output="AppBundle\Entity\Player"
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $players = $this->get('player.service')->findPlayers(['name' => 'asc']);
        $view = $this->view($players);
        return $this->handleView($view);
    }

    /**
     * @FOS\Get()
     * @FOS\View()
     * @ApiDoc(
     *  section="user",
     *  description="Get player data",
     *  output="AppBundle\Document\SinglePlayer",
     *  statusCodes={
     *      404 = "Player not found"
     *  }
     * )
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
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
     *  },
     *  output="AppBundle\Entity\Player"
     * )
     *
     * @param ParamFetcher $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(ParamFetcher $params)
    {
        try {
            $player = $this->get('player.service')->addPlayer($params->get('name'));
            $this->get('event_dispatcher')->dispatch(Events::PLAYER_CREATE, new CreateEvent($player));
            $view = $this->view($player, 200);
        } catch (\InvalidArgumentException $e) {
            $view = $this->view('Player with same name already exists', 404);
        } catch (\Exception $e) {
            $view = $this->view($e->getMessage(), 500);
        }

        return $this->handleView($view);
    }

}
