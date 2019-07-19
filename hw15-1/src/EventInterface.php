<?php

namespace TimGa\Redis;

interface EventInterface
{
    public function getPriority(): string;

    public function getConditions(): array;

    public function getName(): string;

    public function encodeToJson(): string;

    public static function createEventFromJson(string $eventJson): EventInterface;
}
