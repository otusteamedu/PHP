<?php
declare(strict_types=1);

namespace HW15;

use Predis\Client;
use Predis\Transaction\MultiExec;
use stdClass;

class EventProvider
{
    public const EVENT_LAST_ID = 'event:lastId';
    public const EVENT = 'event:';
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Store event to redis
     * @param Event $event
     */
    public function store(Event $event): void
    {
        $that = $this;
        $this->client->transaction(static function ($tx) use ($that, $event) {
            /** @var MultiExec $tx */
            $id = $that->client->incr(self::EVENT_LAST_ID);
            $key = Utils::buildKeyByConditions($event->conditions);
            $tx->zadd($key, [$id => $event->priority]);
            $tx->set($that->getEventKey((string)$id), serialize($event));
        });
    }

    /**
     * @param string $eventId
     * @return string
     */
    public function getEventKey(string $eventId): string
    {
        return self::EVENT . $eventId;
    }

    /**
     * Match and return Event by conditions or null if not match
     * @param array $conditions
     * @return Event|null
     */
    public function pop(array $conditions): ?Event
    {
        [$matchedKey, $matchedId] = $this->getMatchedKeyAndId($conditions);
        if (!$matchedKey || !$matchedId) {
            return null;
        }
        return $this->popEvent($matchedKey, $matchedId);
    }

    /**
     * @param array $conditions
     * @return array
     */
    private function getMatchedKeyAndId(array $conditions): array
    {
        $matchedId = null;
        $matchedKey = null;
        $maxPriority = PHP_INT_MIN;
        foreach (Utils::subArrays($conditions) as $conditionsVariant) {
            $key = Utils::buildKeyByConditions($conditionsVariant);
            if ($this->client->exists($key)) {
                $id = (string)current($this->client->zrevrange($key, 0, 1, []));
                if ($this->getEvent($id)->priority > $maxPriority) {
                    $matchedKey = $key;
                    $matchedId = $id;
                }
            }
        }
        return [$matchedKey, $matchedId];
    }

    /**
     * @param $eventId
     * @return Event
     */
    private function getEvent($eventId): Event
    {
        $eventString = $this->client->get($this->getEventKey($eventId));
        return unserialize($eventString, ['allowed_classes' => [Event::class, stdClass::class]]);
    }

    /**
     * @param string $key
     * @param string $eventId
     * @return Event
     */
    private function popEvent(string $key, string $eventId): Event
    {
        $this->client->zrem($key, $eventId);
        $event = $this->getEvent($eventId);
        $this->client->del([$this->getEventKey($eventId)]);
        return $event;
    }

    /**
     * Clean up redis
     */
    public function clean(): void
    {
        $cursor = 0;
        do {
            [$cursor, $keys] = $this->client->scan($cursor);
            if (!empty($keys)) {
                $this->client->del($keys);
            }
        } while ($cursor > 0);
    }
}
