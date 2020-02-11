<?php

namespace App;

class Event
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
     * @return Event
     */
    public function setName(string $name): Event
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $priority
     * @return Event
     */
    public function setPriority(int $priority): Event
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param array $conditions
     * @return Event
     */
    public function setConditions(array $conditions): Event
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return $this->redis->hMSet($this->name,
            [
                'name' => $this->name,
                'priority' => $this->priority,
                'conditions' => json_encode($this->conditions)
            ]
        );
    }

    public function getPriorityEventByCondition(array $conditions) {
        $maxPriority = 0;
        $priorityEventNames = [];
        $relevantEventsData = [];

        $eventNames = $this->redis->keys('*');
        foreach ($eventNames as $eventName) {
            $eventData = $this->redis->hGetAll($eventName);
            $eventConditions = json_decode($eventData['conditions'], JSON_OBJECT_AS_ARRAY);
            $countEventConditions = count($eventConditions);
            $countRelevantConditions = 0;

            foreach ($eventConditions as $key => $eventCondition) {
                if (array_key_exists($key, $conditions) && ($conditions[$key] == $eventCondition)) {
                    $countRelevantConditions += 1;
                }
            }
            if ($countRelevantConditions == $countEventConditions) {
                if ($eventData['priority'] > $maxPriority) {
                    $maxPriority = $eventData['priority'];
                    unset($priorityEventNames);
                    $priorityEventNames[] = $eventName;
                }
                elseif ($eventData['priority'] == $maxPriority) {
                    $priorityEventNames[] = $eventName;
                }

            }
        }

        foreach ($priorityEventNames as $priorityEventName) {
            $relevantEventsData[] = $this->redis->hGetAll($priorityEventName);
        }

        return $relevantEventsData;
    }

    public function flushAll()
    {
        $this->redis->flushAll();
    }

}