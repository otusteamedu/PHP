<?php

namespace crazydope\events;

interface OccurrenceInterface
{
    public function setPriority(int $priority): OccurrenceInterface;

    public function getPriority(): int;

    public function setCondition(string $key, string $value): OccurrenceInterface;

    public function getCondition(string $key): string;

    public function getConditions(): array;
}