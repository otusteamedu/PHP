<?php
namespace Otus\HW11\Task2;

use \Otus\HW11\Config;
use \Otus\HW11\Task2;

class RedisStorage implements Task2\IStorage
{

    protected $client;


    public function __construct()
    {
        $this->client = new \Predis\Client([
            'scheme' => Config::get('redis')['scheme'],
            'host'   => Config::get('redis')['host'],
            'port'   => Config::get('redis')['port'],
        ]);
    }


    public function setEvent(Task2\Event $event)
    {
        if ( is_null($this->client->get('events:count')) ) {
            $this->client->set('events:count', 0);
        }

        $eventsCounter = $this->client->get('events:count');

        // set events fields
        $this->client->set('events:' . $eventsCounter . ':priority', $event->getPriority());
        $this->client->set('events:' . $eventsCounter . ':event', $event->getEvent());

        // set filter params
        foreach ($event->getConditions() as $param => $value) {
            $paramStorageKey = 'conditions:' . $param . ':' . $value;
            $this->client->sadd($paramStorageKey, [$eventsCounter]);
            $this->client->lpush('conditions:keys', $paramStorageKey);
        }

        $this->client->incr('events:count');

    }


    public function queryExec()
    {
        // TODO: Implement queryExec() method.
    }


    public function clearEvents()
    {
        $eventsCounter = $this->client->get('events:count');

        if ( is_null($eventsCounter) ) {
            $eventsCounter = 0;
        }

        // clear events
        for ($i = 0; $i < $eventsCounter; $i++) {
            $this->client->del('events:' . $i . ':priority');
            $this->client->del('events:' . $i . ':event');
        }

        // clear conditions
        $conditionsCount = $this->client->llen('conditions:keys');
        for ($i = 0; $i < $conditionsCount; $i++) {
            $paramStorageKey = $this->client->lpop('conditions:keys');
            $this->client->del($paramStorageKey);
        }

        // clear events counter
        $this->client->del('events:count');
    }

}
