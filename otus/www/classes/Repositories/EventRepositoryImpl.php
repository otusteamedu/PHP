<?php

namespace Classes\Repositories;

use Classes\Models\Event;

class EventRepositoryImpl implements EventRepositoryInterface
{

    /** @var \Redis $dbClient */
    private $dbClient;

    public function __construct($dbClient)
    {
        $this->dbClient = $dbClient;
        $this->dbClient->connect('otus-redis');
    }

    public function create(Event $event)
    {
        return $this->dbClient->hMSet(
            $event->eventName,
            [
                'name' =>$event->eventName,
                'priority' => $event->eventPriority,
                'criterions' => json_encode($event->eventCriterions, JSON_THROW_ON_ERROR, 512)
            ]
        );
    }

    public function deleteAll()
    {
        return $this->dbClient->flushAll();
    }

    public function getAllKeys()
    {
        return $this->dbClient->keys('*');
    }

    public function getKeyData(string $key)
    {
        return $this->dbClient->hGetAll($key);
    }
}
