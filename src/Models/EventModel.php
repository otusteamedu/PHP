<?php

namespace Models;

use Controllers\RedisController;

class EventModel
{
    protected RedisController $redisController;
    protected int $priority;
    protected array $conditions;

    /**
     * EventModel constructor.
     * @param array $body
     */
    public function __construct(array $body = [])
    {
        $this->redisController = new RedisController();
        if (!empty($body)) {
            $this->priority = $body['priority'];
            $this->conditions = $body['conditions'];
        }
    }

    public function saveEvent(): bool
    {
        return $this->redisController->setEvent([
            'priority' => $this->priority,
            'conditions' => $this->conditions
        ]);
    }

    /**
     * @return array
     */
    public function getAllEvent(): array
    {
        return $this->redisController->getAllEvent();
    }

    /**
     * @param string $key
     * @return array
     */
    public function getEvent(string $key): array
    {
        return $this->redisController->getEvent($key);
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @param array $conditions
     */
    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }


}