<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * AppBundle\Entity\Player
 *
 * @ODM\Document(repositoryClass="PlayerRepository")
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="PlayerRepository")
 */
class Player
{
    const STARTELO = 1500;

    /**
     * Player ID
     * @var string
     *
     * @ODM\Id(strategy="AUTO")
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Type("string")
     */
    protected $id;

    /**
     * Player name
     * @var string
     *
     * @ODM\String(name="name")
     *
     * @ORM\Column(name="name", type="string")
     *
     * @JMS\Type("string")
     */
    protected $name;

    /**
     * Player ELO
     * @var int
     *
     * @ODM\Integer(name="elo")
     *
     * @ORM\Column(name="elo", type="integer")
     *
     * @JMS\Type("integer")
     */
    protected $elo = self::STARTELO;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add game
     *
     * @param Game $game
     */
    public function addGame(Game $game)
    {
        $this->games[] = $game;
    }

    /**
     * Remove game
     *
     * @param Game $game
     */
    public function removeGame(Game $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games
     *
     * @return Game[]|ArrayCollection $games
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Set elo
     *
     * @param integer $elo
     * @return self
     */
    public function setElo($elo)
    {
        $this->elo = $elo;
        return $this;
    }

    /**
     * Get elo
     *
     * @return integer $elo
     */
    public function getElo()
    {
        return $this->elo;
    }

    /**
     * Add points to elo
     *
     * @param int $elochange
     * @return self
     */
    public function addElo($elochange)
    {
        $this->elo += $elochange;
        return $this;
    }

}
