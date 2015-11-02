<?php
namespace AppBundle\Service;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameRepository;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use AppBundle\Entity\SinglePlayer;
use AppBundle\Entity\SinglePlayerGamesPrDay;
use Doctrine\ORM\Query\ResultSetMapping;

class PlayerService
{

    /**
     * @var PlayerRepository
     */
    private $playerRepository;
    /**
     * @var GameRepository
     */
    private $gameRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @param string $name
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function addPlayer($name)
    {
        $player = $this->playerRepository->findOneBy(['name' => $name]);
        if (! $player) {
            $player = new Player();
            $player->setName($name);
            try {
                $this->playerRepository->getManager()->persist($player);
                $this->playerRepository->getManager()->flush();
            } catch (\Exception $e) {
                throw $e;
            }
        }

        throw new \InvalidArgumentException();
    }

    /**
     * @param string $slug
     * @return SinglePlayer
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function singlePlayer($slug)
    {
        $player = $this->playerRepository->findOneBy(['slug' => $slug]);
        if (! $player instanceof Player) {
            throw new \InvalidArgumentException();
        }

        try {
            $single = new SinglePlayer();
            $single->setData($player);
            $single->setGames($this->listGamesByPlayer($player, 30));
            $single->setTotalGames($this->countGamesByPlayer($player));
            $single->setGamesPrDay($this->getGamesPrDay($player));
            return $single;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Player $player
     * @param $limit
     * @return Game[]
     */
    private function listGamesByPlayer(Player $player, $limit)
    {
        $builder = $this->gameRepository->findByPlayer($player->getId());
        $builder->setMaxResults($limit);
        return $builder->getQuery()->getResult();
    }

    /**
     * @param Player $player
     * @return int
     * @throws \Exception
     */
    private function countGamesByPlayer(Player $player)
    {
        $builder = $this->gameRepository->findByPlayer($player->getId());
        $builder->select($builder->expr()->count('game'));
        try {
            return $builder->getQuery()->getSingleScalarResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Player $player
     * @return SinglePlayerGamesPrDay[]
     */
    private function getGamesPrDay(Player $player)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('counter', 'counter', 'integer');
        $rsm->addScalarResult('date', 'date', 'datetime');
        $sql = 'SELECT COUNT(*) as counter, date FROM game WHERE player1_id = :p1 OR player2_id = :p2 GROUP BY DAY(date)';

        $manager = $this->gameRepository->getManager();
        $nq = $manager->createNativeQuery($sql, $rsm);
        $results = $nq->execute([
            'p1' => $player->getId(),
            'p2' => $player->getId()
        ]);

        $out = [];
        foreach($results as $res) {
            $out[] = new SinglePlayerGamesPrDay($res['counter'], $res['date']);
        }
        return $out;
    }

}
