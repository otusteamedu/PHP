<?php

namespace crazydope\events;

interface EventListInterface
{
    public function get(string $key): ?string;

    public function getByCondition(array $conditions): ?EventOccurrenceInterface;

    public function set(EventOccurrenceInterface $eventOccurrence): EventListInterface;

    public function clear();
}