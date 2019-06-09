<?php

namespace App;

/**
 * Class RedisStore
 * @package App
 */
class RedisStore
{
    /**
     * @var \Redis
     */
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('otus-redis');
        if (!$this->redis->keys('events')) {
            $this->saveAll([]);
        }
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function add(Event $event): bool
    {
        $events = $this->getAll();
        $events[] = $event;

        return $this->saveAll($events);
    }

    /**
     * @param string $eventName
     * @return Event|null
     */
    public function get(string $eventName): ?Event
    {
        $events = $this->getAll();

        foreach ($events as $event) {
            if ($event->getName() === $eventName) {
                return $event;
            }
        }

        return null;
    }

    /**
     * @param array $requestCondition
     * @return Event|null
     */
    public function getRelevant(array $requestCondition): ?Event
    {
        $events = $this->getAll();

        if (count($events) > 0) {
            $resultEvents = [];

            foreach ($events as $event) {
                $take = true;

                foreach ($requestCondition as $key => $value) {
                    $eventConditions = $event->getConditions();
                    if (!isset($eventConditions[$key]) || $eventConditions[$key] !== $value) {
                        $take = false;
                    }
                }

                if ($take) {
                    $resultEvents[] = $event;
                }
            }

            $maxPriority = 0;
            $resultEvent = null;

            if (count($resultEvents) > 0) {
                foreach ($resultEvents as $event) {
                    if ($event->getPriority() > $maxPriority) {
                        $maxPriority = $event->getPriority();
                        $resultEvent = $event;
                    }
                }

                return $resultEvent;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function clearAll(): bool
    {
        return $this->saveAll([]);
    }

    /**
     * @return Event[]
     */
    private function getAll(): array
    {
        $events = [];
        $eventsArray = json_decode($this->redis->get('events'), true);

        if (count($eventsArray) > 0) {
            foreach ($eventsArray as $eventArray) {
                $event = new Event(
                    $eventArray['event']['name'],
                    $eventArray['conditions'],
                    $eventArray['priority']
                );
                $events[] = $event;
            }
        }

        return $events;
    }

    /**
     * @param array $events
     * @return bool
     */
    private function saveAll(array $events): bool
    {
        $result = [];

        if (count($events) > 0) {
            foreach ($events as $event) {
                $result[] = $event->toArray();
            }
        }

        return $this->redis->set('events', json_encode($result));
    }
}