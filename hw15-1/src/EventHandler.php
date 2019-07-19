<?php

namespace TimGa\Redis;

class EventHandler
{
    public $redisClient;

    public function __construct(\Predis\ClientInterface $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    public function insertEvent(EventInterface $event)
    {
        $eventName = $event->getName();
        $eventJson = $event->encodeToJson();
        $eventConditions = $event->getConditions();
        $this->insertEventJson($eventName, $eventJson);
        $this->insertConditions($eventName, $eventConditions);
    }

    public function insertEventJson(string $eventName, string $eventJson)
    {
        $key = $eventName;
        $value = $eventJson;
        $this->redisClient->set($key, $value);
    }

    public function insertConditions(string $eventName, array $eventConditions)
    {
        foreach ($eventConditions as $conditionId => $conditionValue) {
            $key = 'condition:id:' . $conditionId . ':val:' . $conditionValue;
            $member = $eventName;
            $this->redisClient->sadd($key, $member);
        }
    }

    public function cleanUp()
    {
        $this->deleteKeysByPattern('event*');
        $this->deleteKeysByPattern('condition*');
    }

    public function deleteKeysByPattern(string $pattern)
    {
        $cursor = 0;
        do {
            $scanResult = $this->redisClient->scan($cursor, ['match' => "$pattern"]);
            $cursor = $scanResult[0];
            $keys = $scanResult[1];
            if (!empty($keys)) {
                $this->redisClient->del($keys);
            }
        } while ($cursor != 0);
    }

    public function findEventByConditions(array $conditions): string
    {
        $keys = [];
        foreach ($conditions as $conditionId => $conditionValue) {
            if (!is_null($conditionValue)) {
                $keys[] = 'condition:id:' . $conditionId . ':val:' . $conditionValue;
            }
        }
        $eventNames = $this->redisClient->sinter($keys);
        if (empty($eventNames)) {
            return 'no matches found';
        }
        $result = $this->filterEventWithMaxPriority($eventNames);
        return $result;
    }

    public function filterEventWithMaxPriority(array $eventNames): string
    {
        foreach ($eventNames as $eventName) {
            $eventJson = $this->redisClient->get($eventName);
            $event = Event::createEventFromJson($eventJson);
            $priorities[$eventName] = $event->getPriority();
        }
        arsort($priorities);
        return key($priorities);
    }
}
