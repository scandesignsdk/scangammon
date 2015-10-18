<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * AppBundle\Entity\Game
 *
 * @ODM\Document(repositoryClass="GameRepository")
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="GameRepository")
 */
class Game
{
    const P1WINNER = 1;
    const P2WINNER = 2;

    /**
     * @var string $id
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
     * @var Player
     *
     * @ODM\ReferenceOne(name="player1", targetDocument="Player")
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     *
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player1;

    /**
     * @var Player
     *
     * @ODM\ReferenceOne(name="player2", targetDocument="Player")
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     *
     * @JMS\Type("AppBundle\Entity\Player")
     */
    protected $player2;

    /**
     * @var int
     *
     * @ODM\Integer(name="winner")
     *
     * @ORM\Column(name="winner", type="integer")
     *
     * @JMS\Type("integer")
     */
    protected $winner;

    /**
     * @var int
     *
     * @ODM\Integer(name="player1_elochange"))
     *
     * @ORM\Column(name="player1elochange", type="integer")
     *
     * @JMS\Exclude()
     */
    protected $player1Elochange;

    /**
     * @var int
     *
     * @ODM\Integer(name="player2_elochange"))
     *
     * @ORM\Column(name="player2elochange", type="integer")
     *
     * @JMS\Exclude()
     */
    protected $player2Elochange;

    /**
     * @var \DateTime
     *
     * @ODM\Date(name="date")
     *
     * @ORM\Column(name="date", type="datetime")
     *
     * @JMS\Type("DateTime")
     */
    protected $date;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set player1
     *
     * @param Player $player1
     * @return self
     */
    public function setPlayer1(Player $player1)
    {
        $this->player1 = $player1;
        return $this;
    }

    /**
     * Get player1
     *
     * @return Player $player1
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * Set player2
     *
     * @param Player $player2
     * @return self
     */
    public function setPlayer2(Player $player2)
    {
        $this->player2 = $player2;
        return $this;
    }

    /**
     * Get player2
     *
     * @return Player $player2
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * Set winner
     *
     * @param integer $winner
     * @return self
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
        return $this;
    }

    /**
     * Get winner
     *
     * @return integer $winner
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set player1Elochange
     *
     * @param int $originalElo
     * @param int $eloChange
     * @return Game
     */
    public function setPlayer1Elochange($originalElo, $eloChange)
    {
        $this->player1Elochange = ($eloChange - $originalElo);
        return $this;
    }

    /**
     * Get player1Elochange
     *
     * @return integer $player1Elochange
     */
    public function getPlayer1Elochange()
    {
        return $this->player1Elochange;
    }

    /**
     * Set player2Elochange
     *
     * @param int $originalElo
     * @param int $eloChange
     * @return Game
     */
    public function setPlayer2Elochange($originalElo, $eloChange)
    {
        $this->player2Elochange = ($eloChange - $originalElo);
        return $this;
    }

    /**
     * Get player2Elochange
     *
     * @return integer $player2Elochange
     */
    public function getPlayer2Elochange()
    {
        return $this->player2Elochange;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return self
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

}
