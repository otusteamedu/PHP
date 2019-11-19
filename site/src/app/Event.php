<?php

namespace App;

use Predis;

class Event
{
    private $name;
    private $priority;
    private $conditions;
    private $redis;

    public function __construct()
    {
        $this->redis = new Predis\Client( [
        'scheme' => 'tcp',
        'host'   => 'redis',
        'port'   => 6379,
        ]);

    }
    public function setName($name)
    {

        $this->name = $name;
    }
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
    public function save()
    {

        return $this->redis->hmset(
            $this->name,
            [
                'event' => $this->name,
                'priority' => $this->priority,
                'conditions' => json_encode($this->conditions),
            ]

        );
    }
    public function getPriorityEvent($conditions)
    {
        $eventNames = $this->redis->keys('*');
        $maxPriority = 0;
        $maxPriorityEvents = '';
        foreach ($eventNames as $valueEventName) {
            $eventData = $this->redis->hgetall($valueEventName);
            $eventConditions = json_decode($eventData['conditions'], JSON_OBJECT_AS_ARRAY);
            $matchCondition = 0;
            foreach ($eventConditions as $keyEventConditions => $valueEventConditions) {
                if (array_key_exists($keyEventConditions, $conditions['params']) &&
                    $conditions['params'][$keyEventConditions] == $valueEventConditions) {
                    $matchCondition++;
                }else{
                break;
                }
            }
            if ($matchCondition <= count($conditions['params'])
            && $matchCondition > 0
            && $eventData['priority'] > $maxPriority) {
            $maxPriority = $eventData['priority'];
            $maxPriorityEvents = $valueEventName;
        }
        }

        $event = $this->redis->hgetall($maxPriorityEvents);
        return $event['event'];
    }

    public function deleteAllEvents()
    {
        $this->redis->flushAll();
    }
}
