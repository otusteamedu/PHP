<?php

namespace crazydope\events;

class EventFactory
{
    public function build(string $eventName, int $priority, array $conditions, string $eventDesc = ''): EventOccurrenceInterface
    {
        $event = new Event($eventName, $eventDesc);
        $eventOccurrence = new EventOccurrence($event);
        $eventOccurrence->setPriority($priority);
        foreach ($conditions as $condition => $value) {
            $eventOccurrence->setCondition($condition, $value);
        }
        return $eventOccurrence;
    }
}