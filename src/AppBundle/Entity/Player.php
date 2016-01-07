<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AppBundle\Entity\Player
 *
 * @ORM\Table(name="player", indexes={
 *  @ORM\Index(name="slug", columns={"slug"}),
 *  @ORM\Index(name="rfidtag", columns={"rfidtag"}),
 *  @ORM\Index(name="win_percent", columns={"win_percent"}),
 * })
 * @ORM\Entity(repositoryClass="PlayerRepository")
 */
class Player
{
    const STARTELO = 1500;

    /**
     * Player ID
     * @var string
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
     * @ORM\Column(name="name", type="string")
     *
     * @JMS\Type("string")
     */
    protected $name;

    /**
     * Player slug
     * @var string
     *
     * @ORM\Column(name="slug", length=128)
     *
     * @Gedmo\Slug(fields={"id", "name"})
     *
     * @JMS\Type("string")
     */
    protected $slug;

    /**
     * Player RFID tag
     * @var string
     *
     * @ORM\Column(name="rfidtag", type="string", nullable=true)
     * @JMS\Exclude()
     */
    protected $rfidtag;

    /**
     * Player ELO
     * @var int
     *
     * @ORM\Column(name="elo", type="integer")
     *
     * @JMS\Type("integer")
     */
    protected $elo = self::STARTELO;

    /**
     * Player ELO
     * @var float
     *
     * @ORM\Column(name="win_percent", type="float")
     *
     * @JMS\Type("double")
     */
    protected $winPercent = 0;

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
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return Player
     */
    public function resetSlug()
    {
        $this->slug = null;
        return $this;
    }

    /**
     * @param string $slug
     * @return Player
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getRfidtag()
    {
        return $this->rfidtag;
    }

    /**
     * @param string $rfidtag
     * @return Player
     */
    public function setRfidtag($rfidtag)
    {
        $this->rfidtag = $rfidtag;
        return $this;
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

    /**
     * Gets the WinPercent
     * @return mixed
     */
    public function getWinPercent()
    {
        return $this->winPercent;
    }

    /**
     * @param mixed $winPercent
     *
     * @return Player
     */
    public function setWinPercent($winPercent)
    {
        $this->winPercent = $winPercent;

        return $this;
    }

}
