<?php

namespace crazydope\events;

interface EventOccurrenceInterface extends OccurrenceInterface
{
    public static function jsonDeserialize(string $json): EventOccurrenceInterface;

    public function getEvent(): EventInterface;

    public function toArray(): array;
}