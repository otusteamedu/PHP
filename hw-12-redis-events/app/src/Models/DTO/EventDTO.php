<?php

namespace App\Models\DTO;

class EventDTO extends DTO
{
    public int    $id;
    public int    $priority;
    public array  $conditions;
    public string $event;

    public function __construct (
        int $id,
        int $priority,
        array $conditions,
        string $event
    )
    {
        $this->id         = $id;
        $this->priority   = $priority;
        $this->conditions = $conditions;
        $this->event      = $event;
    }
}