<?php


namespace Otushw;

interface StorageInterface
{
    public function create(VideoDTO $source): bool;

    public function read(int $id): ?VideoDTO;

    public function update(int $id, VideoDTO $source): bool;

    public function delete(int $id): bool;

    public function getItems(int $limit = 10, int $offset = 0): array;

    public function getCount(): int;

    public function getSumField(string $fieldName): int;
}