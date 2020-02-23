<?php

namespace App\Mappers;

interface DataMapperInterface
{
    public function findById($id): object;
    public function insert(object $entity): int;
    public function update(object $entity): bool;
    public function delete(object $entity): bool;
}