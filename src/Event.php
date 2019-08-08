<?php

namespace hw15;

use Exception;

/**
 * Class Event
 * @package hw15
 *
 * @property  string $id
 * @property  int $priority
 * @property  array $conditions
 * @property  EventItem $eventItem
 */
class Event
{
    private $id;
    private $priority;
    private $conditions;
    private $eventItem;

    public function __construct()
    {
        $this->id = uniqid();
    }

    public function getId(): string
    {
        return $this->eventItem;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getEventItem(): EventItem
    {
        return $this->eventItem;
    }

    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
    }

    public function setEventItem(EventItem $eventItem)
    {
        $this->eventItem = $eventItem;
    }

    /**
     * @param string $data
     * @return bool
     * @throws \Exception
     */
    public function loadFromJson(string $data): bool
    {
        $data = json_decode($data, true);

        if (!isset($data['priority']) || !isset($data['conditions']) || !isset($data['event'])
            || !isset($data['event']['name']) || !isset($data['event']['description'])) {
            throw new Exception('Not enough data!');
        }

        $this->setPriority($data['priority']);

        $this->setConditions($data['conditions']);

        $this->setEventItem(new EventItem($data['event']['name'], $data['event']['description']));

        return true;
    }
}