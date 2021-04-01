<?php


namespace App\Services\Orm\Interfaces;


interface MapperInterface
{
    public function insert(array $raw): ModelInterface;
    public function update(ModelInterface $model): bool;
    public function delete(ModelInterface $model): bool;
    public function findById(int $id): ?ModelInterface;
}
