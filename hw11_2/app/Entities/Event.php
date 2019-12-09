<?php

namespace App\Entities;

class Event
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $priority;
    /**
     * @var array
     */
    protected $conditions = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName(string $name): Event
    {
        $this->name = $name;
        return $this;
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
     * @return Event
     */
    public function setPriority(int $priority): Event
    {
        $this->priority = $priority;
        return $this;
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
     * @return Event
     */
    public function setConditions(array $conditions): Event
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @param array $data
     * @return Event
     */
    public static function createFromArray(array $data): Event
    {
        $event = new self;

        foreach ($data as $key => $value) {
            $setterName = 'set' . lcfirst($key);
            if (method_exists($event, $setterName)) {
                $event->{$setterName}($value);
            }
        }

        return $event;
    }
}
