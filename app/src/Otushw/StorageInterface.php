<?php


namespace Otushw;

interface StorageInterface
{
    public function create(array $source): bool;

    public function read(int $id): array;

    public function update(int $id, array $source): bool;

    public function delete(int $id): bool;

    public function getItems(int $limit = 10, int $offset = 0): array;

    public function getCount(): int;

    public function getSumField(string $fieldName): int;
}