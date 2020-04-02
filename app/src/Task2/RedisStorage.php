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


    public function setEvent(\DS\Vector $params, Task2\Event $event)
    {
        if ( is_null($this->client->get('events:count')) ) {
            $this->client->set('events:count', 0);
        }

        $eventsCounter = $this->client->get('events:count');

        // set events fields
        $this->client->set('events:' . $eventsCounter . ':priority', $event->getPriority());
        $this->client->set('events:' . $eventsCounter . ':event', $event->getRawData());

        // set filter params
        foreach ($params as $param) {
            $paramStorageKey = 'conditions:' . $param->getName() . ':' . $param->getValue();
            $this->client->sadd($paramStorageKey, [$eventsCounter]);

            // Save keys for clearing
            $this->client->sadd('conditions:keys', [$paramStorageKey]);
        }

        $this->client->incr('events:count');
    }


    /**
     * @param \DS\Vector $params (collection of \Otus\HW11\Task2\Param)
     * @return mixed
     */
    public function queryExec(\DS\Vector $params)
    {
        $arSetKeys = [];
        foreach ($params as $param) {
            $arSetKeys[] = 'conditions:' . $param->getName() . ':' . $param->getValue();
        }

        $arEventsId = $this->client->sinter($arSetKeys);

        if ( empty($arEventsId) ) {
            return null;
        }

        $arEventPriority = [];
        foreach ($arEventsId as $eventId) {
            $arEventPriority[$eventId] = $this->client->get('events:' . $eventId . ':priority');
        }

        // Search event by max priority
        $needEventId = array_keys($arEventPriority, max($arEventPriority))[0];

        return new Task2\Event(
            intval($arEventPriority[$needEventId]),
            $this->client->get('events:' . $needEventId . ':event')
        );
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
        while ($paramStorageKey = $this->client->spop('conditions:keys')) {
            $this->client->del($paramStorageKey);
        }

        // clear events counter
        $this->client->del('events:count');
    }

}
