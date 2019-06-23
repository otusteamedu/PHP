<?php

namespace crazydope\events;

use Predis\ClientInterface;

class EventList implements EventListInterface
{
    public const EVENT_ID = 'event.id';
    public const EVENT = 'event';
    public const EVENT_CONDITION = 'event.condition';

    /**
     * @var ClientInterface
     */
    protected $client;

    protected function beginTransaction(): void
    {
        $this->client->multi();
    }

    protected function commit(): void
    {
        $this->client->exec();
    }

    /**
     * @param string $key
     */
    protected function increment(string $key): void
    {
        $this->client->incr($key);
    }

    /**
     * @param string $name
     * @param string $value
     * @param int $id
     */
    protected function setCondition(string $name, string $value, int $id): void
    {
        $this->client->sadd(self::EVENT_CONDITION . '.' . $name . '.' . $value, [$id]);
    }

    /**
     * @param array $ids
     * @param array $conditions
     * @return EventOccurrenceInterface|null
     */
    protected function filterEvents(array $ids, array $conditions): ?EventOccurrenceInterface
    {
        $events = [];
        foreach ($ids as $id) {
            $json = $this->get(self::EVENT . '.' . $id);

            if (!$json) {
                continue;
            }

            $event = EventOccurrence::jsonDeserialize($json);
            if ($event->getConditions() !== $conditions) {
                continue;
            }
            $events[] = $event;
        }

        if(empty($events)) {
            return null;
        }

        usort($events, function ($a, $b) {
            return ($a->getPriority() <=> $b->getPriority());
        });

        return end($events);
    }

    /**
     * EventList constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $conditions
     * @return EventOccurrenceInterface|null
     */
    public function getByCondition(array $conditions): ?EventOccurrenceInterface
    {
        $keys = [];
        foreach ($conditions as $condition => $value) {
            $keys[] = "event.condition.$condition.$value";
        }

        $ids = $this->client->sinter($keys);

        if (!$ids) {
            return null;
        }

        return $this->filterEvents($ids, $conditions);
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return $this->client->get($key);
    }

    /**
     * @param EventOccurrenceInterface $eventOccurrence
     * @return EventListInterface
     */
    public function set(EventOccurrenceInterface $eventOccurrence): EventListInterface
    {
        $this->increment(self::EVENT_ID);
        $eventId = $this->get(self::EVENT_ID);

        $this->beginTransaction();
        $eventOccurrence->getEvent()->setId($eventId);
        $this->client->set(self::EVENT . '.' . $eventId, \json_encode($eventOccurrence->toArray()));

        foreach ($eventOccurrence->getConditions() as $condition => $value) {
            $this->setCondition($condition, $value, $eventId);
        }
        $this->commit();
        return $this;
    }

    /**
     * @return EventListInterface
     */
    public function clear(): EventListInterface
    {
        $keys = $this->client->keys(self::EVENT . '.*');
        $this->client->del(is_array($keys) ? $keys : [$keys]);
        return $this;
    }
}