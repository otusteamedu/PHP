<?php
namespace Otus\HW11\Task2;

/**
 * Class Event
 * @package Otus\HW11\Task2
 */
class Event
{
    protected $priority;
    protected $data;

    /**
     * Event constructor.
     * @param int $priority
     * @param string $data
     */
    public function __construct(int $priority, string $data)
    {
        $this->priority = $priority;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getRawData(): string
    {
        return $this->data;
    }

}
