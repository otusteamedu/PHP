<?php

namespace App;

/**
 * Class Event
 * @package App
 */
class Event
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $conditions;

    /**
     * @var string
     */
    private $priority;

    /**
     * Event constructor.
     * @param $name
     * @param $conditions
     * @param $priority
     */
    public function __construct(string $name, array $conditions, int $priority)
    {
        $this->name = $name;
        $this->conditions = $conditions;
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'priority' => $this->priority,
            'conditions' => $this->conditions,
            'event' => ['name' => $this->name]
        ];
    }
}