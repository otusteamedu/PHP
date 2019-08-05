<?php

namespace App\Models;

class Event
{
    protected $priority;
    protected $conditions = [];
    protected $event;

    /**
     * Event constructor.
     * @param $priority
     * @param array $conditions
     * @param $event
     */
    public function __construct($priority, array $conditions, $event)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }


    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param array $conditions
     */
    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $enum
     */
    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function __wakeup()
    {
        foreach (get_object_vars($this) as $k => $v) {
            $this->{$k} = $v;
        }
    }


}