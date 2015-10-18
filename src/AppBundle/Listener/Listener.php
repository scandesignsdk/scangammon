<?php
namespace AppBundle\Listener;

use AppBundle\Event as Event;
use AppBundle\Events;
use AppBundle\Stats\Stats;
use JMS\Serializer\Serializer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Listener implements EventSubscriberInterface
{

    /**
     * @var \Pusher
     */
    private $pusher;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Stats
     */
    private $stats;

    public function __construct(\Pusher $pusher, Serializer $serializer, Stats $stats)
    {
        $this->pusher = $pusher;
        $this->serializer = $serializer;
        $this->stats = $stats;
    }

    public function createPlayer(Event\Player\CreateEvent $event)
    {
        $this->pusher->trigger(
            'scangammon',
            Events::PLAYER_CREATE,
            $this->serializer->serialize($event->getPlayer(), 'json')
        );

        $this->pusher->trigger(
            'scangammon',
            Events::STATS_UPDATED,
            $this->serializer->serialize($this->stats->getAll(), 'json')
        );
    }

    public function createGame(Event\Game\CreateEvent $event)
    {
        $this->pusher->trigger(
            'scangammon',
            Events::GAME_CREATED,
            $this->serializer->serialize($event->getGame(), 'json')
        );

        $this->pusher->trigger(
            'scangammon',
            Events::STATS_UPDATED,
            $this->serializer->serialize($this->stats->getAll(), 'json')
        );
    }

    public function deleteGame(Event\Game\DeleteEvent $event)
    {
        $this->pusher->trigger(
            'scangammon',
            Events::GAME_DELETED,
            $this->serializer->serialize($event->getGame(), 'json')
        );

        $this->pusher->trigger(
            'scangammon',
            Events::STATS_UPDATED,
            $this->serializer->serialize($this->stats->getAll(), 'json')
        );
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PLAYER_CREATE => 'createPlayer',
            Events::GAME_CREATED => 'createGame',
            Events::GAME_DELETED => 'deleteGame'
        ];
    }
}
