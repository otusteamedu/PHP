<?php

namespace crazydope\events;

class EventOccurrence extends AbstractOccurrence implements EventOccurrenceInterface
{
    /**
     * @var EventInterface
     */
    protected $event;

    public static function jsonDeserialize(string $json): EventOccurrenceInterface
    {
        $object = \json_decode($json);

        if(!isset($object->event)){
            throw new \InvalidArgumentException('Invalid json object');
        }

        $event = Event::jsonDeserialize($object->event);
        $eventOccurrence = new EventOccurrence($event);
        if(isset($object->priority)) {
            $eventOccurrence->setPriority($object->priority);
        }

        if(isset($object->conditions)) {
            foreach ($object->conditions as $condition => $value) {
                $eventOccurrence->setCondition($condition, $value);
            }
        }
        return $eventOccurrence;
    }


    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    public function getEvent(): EventInterface
    {
        return $this->event;
    }

    public function toArray(): array
    {
        return [
            'priority' => $this->getPriority(),
            'conditions' => $this->getConditions(),
            'event' => $this->event->toArray()
        ];
    }
}