<?php


namespace Repetitor202\Domain\DTO;


class EventStoreDTO
{
    public int $id;
    public int $priority;
    public array $conditions;
    public string $name;

    public function __construct(
        int $id,
        int $priority,
        array $conditions,
        string $name
    ) {
        $this->id = $id;
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->name = $name;
    }
}