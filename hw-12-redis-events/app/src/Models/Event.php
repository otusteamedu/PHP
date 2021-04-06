<?php

namespace App\Models;

use App\Models\DTO\EventDTO;

class Event
{
    private EventDTO $eventDTO;

    public function __construct(EventDTO $eventDTO)
    {
        $this->eventDTO = $eventDTO;
    }

    public function toJson()
    {
        return json_encode(
            [
                'id'         => $this->eventDTO->getId(),
                'priority'   => $this->eventDTO->getPriority(),
                'conditions' => $this->eventDTO->getConditions(),
                'event'      => $this->eventDTO->getEvent(),
            ]
        );
    }

    public function getConditionsStrings (): array
    {
        $result = [];

        foreach ($this->eventDTO->getConditions() as $k => $v) {
            $result[] = Condition::getConditionString($k, $v);
        }

        return $result;
    }
}