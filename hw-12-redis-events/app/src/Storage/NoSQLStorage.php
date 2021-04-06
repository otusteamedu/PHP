<?php

namespace App\Storage;

use App\Models\DTO\EventDTO;

abstract class NoSQLStorage
{
    abstract public function search (array $params): ?string;
    abstract public function store (EventDTO $eventDTO): bool;
    abstract public function deleteAll (): int;
    abstract public function getList (): array;
}