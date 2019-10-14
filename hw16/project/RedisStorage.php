<?php
declare(strict_types=1);
require_once 'Event.php';

class RedisStorage
{
    /** @var \Predis\Client */
    private $client;

    public function __construct(string $uri)
    {
        $this->client = new \Predis\Client($uri);
    }

    /**
     * @return \Predis\Client
     */
    public function getClient(): \Predis\Client
    {
        return $this->client;
    }

    /**
     * @param Event $event
     * @throws Exception
     */
    public function addEvent(Event $event)
    {
        if ($this->client->exists($event->getName())) {
            throw new Exception('Такое событие уже существует');
        }
        $this->client->hmset(
            $event->getName(),
            [
                'priority' => $event->getPriority(),
                'parameter1' => $event->getParameter1(),
                'parameter2' => $event->getParameter2()
            ]
        );
        $this->client->sadd($event->getParameter1(), [$event->getName()]);
        $this->client->sadd($event->getParameter2(), [$event->getName()]);
    }

    /**
     * @param Event $modifiedEvent
     * @throws Exception
     */
    public function modifyEvent(Event $modifiedEvent)
    {
        if (!$this->client->exists($modifiedEvent->getName())) {
            throw new Exception('Такое событие не существует');
        }
        $this->client->hmset(
            $modifiedEvent->getName(),
            [
                'priority' => $modifiedEvent->getPriority(),
                'parameter1' => $modifiedEvent->getParameter1(),
                'parameter2' => $modifiedEvent->getParameter2()
            ]
        );
        if ($this->client->sismember($modifiedEvent->getParameter1(), $modifiedEvent->getName())) {
            $this->client->srem($modifiedEvent->getParameter1(), $modifiedEvent->getName());
        }
        if ($this->client->sismember($modifiedEvent->getParameter2(), $modifiedEvent->getName())) {
            $this->client->srem($modifiedEvent->getParameter2(), $modifiedEvent->getName());
        }
        $this->client->sadd($modifiedEvent->getParameter1(), [$modifiedEvent->getName()]);
        $this->client->sadd($modifiedEvent->getParameter2(), [$modifiedEvent->getName()]);
    }

    /**
     * @param array $params
     * @return Event
     */
    public function getEvent(array $params): Event
    {
        return $this->getHighestPriorityEvent($this->getEventsByParams($params));
    }

    public function deleteAllEvents()
    {
        $this->client->flushdb();
    }

    /**
     * @param string $name
     * @return Event
     */
    private function getEventByName(string $name): Event
    {
        $eventFromStorage = $this->client->hgetall($name);
        return new Event(
            $name,
            (int)$eventFromStorage['priority'],
            $eventFromStorage['parameter1'],
            $eventFromStorage['parameter2']
        );
    }

    /**
     * @param array $params
     * @return array
     */
    private function getEventsByParams(array $params): array 
    {
        $events = [];
        foreach ($this->client->sinter($params) as $eventName) {
            $events[] = $this->getEventByName($eventName);
        }
        return $events;
    }

    /**
     * @param array $events
     * @return Event
     */
    private function getHighestPriorityEvent(array $events): Event
    {
        $eventsWithPriority = [];

        foreach ($events as $event) {
            $eventsWithPriority[$event->getName()] = $event->getPriority();
        }
        arsort($eventsWithPriority);
        return $this->getEventByName(array_shift(array_keys($eventsWithPriority)));

    }

}