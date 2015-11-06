<?php
namespace AppBundle\Service;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameRepository;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerGame;
use AppBundle\Entity\PlayerRepository;
use FOS\RestBundle\Request\ParamFetcherInterface;

class GameService
{

    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @var EloCalculator
     */
    private $eloCalculator;

    public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository, EloCalculator $eloCalculator)
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
        $this->eloCalculator = $eloCalculator;
    }

    /**
     * @param ParamFetcherInterface $params
     * @return Game
     * @throws \InvalidArgumentException
     */
    public function createGame(ParamFetcherInterface $params)
    {
        try {
            $p1 = $this->findPlayerById($params->get('p1'));
            if (!$p1 instanceof Player) {
                throw new \InvalidArgumentException('Player 1 not found');
            }

            $p2 = $this->findPlayerById($params->get('p2'));
            if (!$p2 instanceof Player) {
                throw new \InvalidArgumentException('Player 2 not found');
            }

            if (!in_array((int)$params->get('winner'), [Game::P1WINNER, Game::P2WINNER], true)) {
                throw new \InvalidArgumentException('Winner not correct format');
            }

            if (!in_array((int)$params->get('wintype'), [Game::WINTYPE_NORMAL, Game::WINTYPE_GAMMON, Game::WINTYPE_BACKGAMMON], true)) {
                throw new \InvalidArgumentException('Wintype not correct format');
            }

            list($p1Elo, $p2Elo) = $this->eloCalculator->getNewElo($p1, $p2, $params->get('winner'), $params->get('wintype'));

            $gameClass = $this->gameRepository->getClassName();
            /** @var Game $game */
            $game = new $gameClass;
            $game
                ->setPlayer1($p1)
                ->setPlayer2($p2)
                ->setWinner($params->get('winner'))
                ->setPlayer1Elochange($p1->getElo(), $p1Elo)
                ->setPlayer2Elochange($p2->getElo(), $p2Elo)
                ->setWintype($params->get('wintype'))
            ;

            $this->save($game, false);

            $p1->setElo($p1Elo);
            $p2->setElo($p2Elo);

            $this->save($p1, false);
            $this->save($p2, true);
            return $game;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Unexcepted error (' . $e->getMessage() . ')');
        }
    }

    private function save($obj, $flush = true)
    {
        $this->playerRepository->getManager()->persist($obj);
        if ($flush) {
            $this->playerRepository->getManager()->flush();
        }
    }

    /**
     * @param int $limit
     * @return Game[]
     */
    public function listGames($limit = 10)
    {
        return $this->gameRepository->findBy([], ['date' => 'DESC'], $limit);
    }

    /**
     * @param int $player1
     * @param int $player2
     * @param int $limit
     *
     * @return PlayerGame
     * @throws \InvalidArgumentException
     */
    public function listGamesByPlayers($player1, $player2, $limit = 10)
    {
        $p1 = $this->findPlayerById($player1);
        if (! $p1) {
            throw new \InvalidArgumentException('Player 1 not found');
        }

        $p2 = $this->findPlayerById($player2);
        if (! $p2) {
            throw new \InvalidArgumentException('Player 2 not found');
        }

        $data = $this->eloCalculator->getPlayerstats($p1, $p2);
        $builder = $this->gameRepository->findByPlayers($p1, $p2);
        $builder->setMaxResults($limit);
        $results = $builder->getQuery()->getResult();
        foreach($results as $result) {
            $data->addGame($result);
        }

        return $data;
    }

    /**
     * @param string $player
     * @return Player|null
     */
    private function findPlayerById($player)
    {
        try {
            return $this->playerRepository->find($player);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param string $id
     * @return Game
     * @throws \Exception
     */
    public function deleteGame($id)
    {
        try {
            $game = $this->gameRepository->find($id);
            if (!$game instanceof Game) {
                throw new \InvalidArgumentException('Game not found');
            }

            // recalculate elo
            $p1 = $game->getPlayer1();
            $p2 = $game->getPlayer2();
            $p1->addElo($game->getPlayer1Elochange());
            $p2->addElo($game->getPlayer2Elochange());
            $this->save($p1, false);
            $this->save($p2, false);
            // delete game
            $this->gameRepository->getManager()->remove($game);
            $this->gameRepository->getManager()->flush();
            return $game;
        } catch (\Exception $e) {
            throw $e;
        }

    }

}
