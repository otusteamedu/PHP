<?php

namespace App;

class EventModel
{
    private $name;
    private $priority;
    private $conditions;

    private $redis;

    public function __construct()
    {
        $redisInstance = new \Redis();
        $redisInstance->connect('redis', 6379);
        $this->redis = $redisInstance;
    }

    /**
     * @param string $name
     * @return EventModel
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $priority
     * @return EventModel
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param array $conditions
     * @return EventModel
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @return bool
     */
    public function save()
    {
        return $this->redis->hMSet($this->name,
            [
                'name' => $this->name,
                'priority' => $this->priority,
                'conditions' => json_encode($this->conditions)
            ]
        );
    }

    /**
     * @param array $conditions
     * @return array
     */
    public function getBestEventByConditions(array $conditions)
    {
        $eventNames = $this->redis->keys('*');
        $maxPriority = 0;
        $bestEventName = '';
        $matchedEventsData = [];
        foreach ($eventNames as $eventName) {
            $eventData = $this->redis->hGetAll($eventName);
            $eventConditions = json_decode($eventData['conditions'], JSON_OBJECT_AS_ARRAY);
            $countMatchedConditions = 0;
            foreach ($eventConditions as $key => $value) {
                if (
                    array_key_exists($key, $conditions)
                    && ($conditions[$key] == $value)
                ) {
                    $countMatchedConditions++;
                }
                if ($countMatchedConditions == count($eventConditions)) {
                    $matchedEventsData[$eventName] = $eventData;
                    if ($eventData['priority'] > $maxPriority) {
                        $maxPriority = $eventData['priority'];
                        $bestEventName = $eventName;
                    }
                }
            }
        }
        $bestEvent = $this->redis->hGetAll($bestEventName);
        return $bestEvent;
    }

    public function flushAll()
    {
        $this->redis->flushAll();
    }

}