<?php


namespace App\Service;


use JsonSerializable;

interface CrudInterface
{
    public function create(array $raw): ?JsonSerializable;
    public function read(int $id): ?JsonSerializable;
    public function update(array $raw): bool;
    public function delete(int $id): bool;
    /**
     * @return \JsonSerializable[]
     */
    public function getAll(int $limit = null, int $offset = null): array;
}
