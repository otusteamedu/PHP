<?php


namespace App\Model;


use App\Model\Interfaces\ModelEventInterface;

class Event implements ModelEventInterface
{
    private int $id;
    private int $priority;
    private array $condition;
    private string $event;

    /**
     * @return array
     */
    public function getCondition(): array
    {
        return $this->condition;
    }

    /**
     * @param array
     */
    public function setCondition(array $params): void
    {
        $this->condition = $params;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
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


    public function toArray(): array
    {
        $arr = [
            'priority' => $this->getPriority(),
            'event' => $this->getEvent()
        ];

        return array_merge($arr, $this->getCondition());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}

