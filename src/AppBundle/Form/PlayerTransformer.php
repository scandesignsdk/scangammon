<?php
namespace AppBundle\Form;

use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PlayerTransformer implements DataTransformerInterface
{

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param $player
     *
     * @return mixed The value in the transformed representation
     */
    public function transform($player)
    {
        if (null === $player) {
            return '';
        }

        return $player->getId();
    }

    /**
     * @param int $playerid
     *
     * @return Player
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($playerid)
    {
        if (! $playerid) {
            return ;
        }

        $player = $this->playerRepository->find($playerid);
        if (! $player) {
            throw new TransformationFailedException('Player with id "%s" does not exists', $playerid);
        }

        return $player;
    }
}
