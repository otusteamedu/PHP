<?php

namespace App\Domain;

final class Event
{
    public ?string $id = null;
    public int $priority;
    public array $event;
    public array $conditions;

    public function __construct(int $priority, array $conditions, array $event)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }
}
