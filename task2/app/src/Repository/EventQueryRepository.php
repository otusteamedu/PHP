<?php


namespace App\Repository;


use App\Database\RedisManager;

class EventQueryRepository extends RedisManager
{
    public function getPriorityEvent(array $conditions)
    {
        $maxPriority = 0;
        $priorityEventNames = [];
        $relevantEventsData = [];

        $eventNames = $this->conn->keys('*');
        foreach ($eventNames as $eventName) {
            $eventData = $this->conn->hGetAll($eventName);
            $eventConditions = json_decode($eventData['conditions'], JSON_OBJECT_AS_ARRAY);
            $countEventConditions = count($eventConditions);
            $relevantConditions = 0;
            foreach ($eventConditions as $key => $eventCondition) {
                if (array_key_exists($key, $conditions) && ($conditions[$key] == $eventCondition)) {
                    $relevantConditions += 1;
                }
            }
            if ($relevantConditions == $countEventConditions) {
                if ($eventData['priority'] > $maxPriority) {
                    $maxPriority = $eventData['priority'];
                    unset($priorityEventNames);
                    $priorityEventNames[] = $eventName;
                } elseif ($eventData['priority'] == $maxPriority) {
                    $priorityEventNames[] = $eventName;
                }
            }
        }
        foreach ($priorityEventNames as $priorityEventName) {
            $relevantEventsData[] = $this->conn->hGetAll($priorityEventName);
        }

        return $relevantEventsData;
    }
}