<?php


namespace RedisApp;


class EventController extends EventModel
{
    public function getBestEventByConditions(array $conditions): array
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
        return $this->redis->hGetAll($bestEventName);
    }
}