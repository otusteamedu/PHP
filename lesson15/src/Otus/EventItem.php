<?php

namespace Otus;

use JsonSerializable;

/**
 * Class EventItem
 * Some EventItem data
 * @package Otus
 */
class EventItem implements JsonSerializable
{
    /**
     * Priority
     * @var int
     */
    private $priority = 0;

    /**
     * Event
     * @var Event
     */
    private $event;

    /**
     * Conditions
     * @var array
     */
    private $conditions = [];

    /**
     * EventItem constructor.
     * @param Event|null $event
     */
    public function __construct(Event $event = null)
    {
        $this->event = $event;
    }

    /**
     * Get Priority
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * Set Priority
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * Get Event
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * Set Event
     * @param Event $event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    /**
     * Get Conditions
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * Set Conditions
     * @param array $conditions
     */
    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

    /**
     * Hook for get private values in json
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}