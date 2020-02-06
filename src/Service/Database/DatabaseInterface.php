<?php declare(strict_types=1);

namespace Service\Database;

use MongoDB\Collection;

interface DatabaseInterface
{
    public function saveOne(object $object): string;

    public function getOne(string $id): ?object;

    public function get(array $filter): array;

    public function getCollection(): Collection;

    public function deleteOne(string $id): int;
}
