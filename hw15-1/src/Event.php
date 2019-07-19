<?php

namespace TimGa\Redis;

class Event implements EventInterface
{
    public $priority = '';
    public $conditions = [];
    public $name = '';

    public function __construct(int $priority, array $conditions, string $name)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->name = $name;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function encodeToJson(): string
    {
        $eventAsArray = [
            'priority' => $this->priority,
            'conditions' => $this->conditions,
            'event' => $this->name,
        ];
        return json_encode($eventAsArray);
    }

    public static function createEventFromJson(string $eventJson): EventInterface
    {
        $decodedJson = json_decode($eventJson);
        $priority = $decodedJson->priority;
        $conditions = $decodedJson->conditions;
        $name = $decodedJson->event;
        return new self($priority,$conditions,$name);
    }
}
