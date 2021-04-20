<?php

declare(strict_types=1);

namespace App\Model\Event\Entity;

use InvalidArgumentException;

class Event
{

    private EventId $id;
    private string  $name;
    private int    $priority;
    /**
     * @var Condition[]
     */
    private array $conditions = [];

    public function __construct(EventId $id, string $name, int $priority)
    {
        $this->assertNameIsNotEmpty($name);

        $this->id = $id;
        $this->name = $name;
        $this->priority = $priority;
    }

    private function assertNameIsNotEmpty(string $title): void
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException('Не указано название события');
        }
    }

    public function changeName(string $name): void
    {
        $this->assertNameIsNotEmpty($name);

        $this->name = $name;
    }

    public function changePriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function addCondition(Condition $condition): void
    {
        if ($this->isConditionExist($condition)) {
            throw new InvalidArgumentException('Условие уже существует');
        }

        $this->conditions[] = $condition;
    }

    private function isConditionExist(Condition $condition): bool
    {
        return !!array_filter($this->conditions, fn($existingCondition) => $existingCondition->isEqual($condition));
    }

    /**
     * @return Condition[]
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id->getValue(),
            'name'       => $this->name,
            'priority'   => $this->priority,
            'conditions' => array_map(fn($condition) => $condition->toArray(), $this->conditions),
        ];
    }

}