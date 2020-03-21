<?php
namespace Otus\HW11\Task2;

/**
 * Class Event
 * @package Otus\HW11\Task2
 */
class Event
{
    protected $priority;
    protected $conditions;
    protected $event;

    /**
     * Event constructor.
     * @param int $priority
     * @param array $conditions
     * @param string $event
     */
    public function __construct(int $priority, array $conditions, string $event)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }


    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }


    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }


    /**
     * @return mixed
     */
    public function getConditions()
    {
        return $this->conditions;
    }

}
