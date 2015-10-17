<?php
namespace AppBundle\Service;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameRepository;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @var EloService
     */
    private $elo;

    public function __construct(EloService $elo, GameRepository $gameRepository, PlayerRepository $playerRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
        $this->elo = $elo;
    }

    /**
     * @param ParamFetcher $params
     * @return Game
     * @throws \InvalidArgumentException
     */
    public function createGame(ParamFetcher $params)
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

            $elo = $this->elo->calculate(
                $p1->getElo(),
                $p2->getElo(),
                (Game::P1WINNER === (int)$params->get('winner') ? 1 : 0),
                (Game::P2WINNER === (int)$params->get('winner') ? 1 : 0)
            );

            $gameClass = $this->gameRepository->getClassName();
            /** @var Game $game */
            $game = new $gameClass;
            $game
                ->setPlayer1($p1)
                ->setPlayer2($p2)
                ->setWinner($params->get('winner'))
                ->setPlayer1Elochange($p1->getElo(), $elo[1])
                ->setPlayer2Elochange($p2->getElo(), $elo[2]);

            $this->save($game, false);

            $p1->setElo($elo[1]);
            $p2->setElo($elo[2]);

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
     * @param $player1
     * @param $player2
     * @param int $limit
     * @return mixed
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
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

        $data = [];
        $data = array_merge($data, $this->addResults($p1, $p2, $limit));
        $data = array_merge($data, $this->addResults($p2, $p1, $limit));
        return $data;
    }

    /**
     * @param Player $p1
     * @param Player $p2
     * @param $limit
     * @return array
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    private function addResults(Player $p1, Player $p2, $limit)
    {
        $builder = $this->gameRepository->findByPlayers($p1, $p2);
        $builder->limit($limit);
        $results = $builder->getQuery()->execute();
        $data = [];
        foreach($results as $result) {
            $data[] = $result;
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
