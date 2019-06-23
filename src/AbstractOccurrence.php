<?php

namespace crazydope\events;

class AbstractOccurrence implements OccurrenceInterface
{
    protected $priority = 0;

    protected $conditions = [];

    /**
     * @param int $priority
     * @return OccurrenceInterface
     */
    public function setPriority(int $priority): OccurrenceInterface
    {
        $this->priority = $priority;
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
     * @param string $key
     * @param string $value
     * @return OccurrenceInterface
     */
    public function setCondition(string $key, string $value): OccurrenceInterface
    {
        $this->conditions[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getCondition(string $key): string
    {
        if (!isset($this->conditions[$key])) {
            throw  new \InvalidArgumentException('Value not found');
        }

        return $this->conditions[$key];
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }
}