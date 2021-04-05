<?php

namespace App\Models;

use App\Models\DTO\EventDTO;

class Event
{
    public static function toJson(EventDTO $eventDTO)
    {
        return json_encode(
            [
                'id'         => $eventDTO->id,
                'priority'   => $eventDTO->priority,
                'conditions' => $eventDTO->conditions,
                'event'      => $eventDTO->event,
            ]
        );
    }
}