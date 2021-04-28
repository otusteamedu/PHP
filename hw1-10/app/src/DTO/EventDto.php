<?php
namespace Src\DTO;

/**
 * DTO structure for event
 *
 *
 * @property string $uid
 * @property int $priority
 * @property array $conditions
 * @property string $event
 */
class EventDto
{
    public string $uid;

    public int $priority;

    public array $conditions;

    public string $event;

    public function __construct(
        string $uid,
        int $priority,
        array $conditions,
        string $event
    ) {
        $this->uid = $uid;
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}