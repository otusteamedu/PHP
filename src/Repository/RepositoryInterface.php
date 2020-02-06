<?php declare(strict_types=1);

namespace Repository;

interface RepositoryInterface
{
    public function findOne(string $id): ?object;

    public function find(array $filter): array;

    public function saveOne(object $object): string;

    public function deleteOne(string $id): int;
}