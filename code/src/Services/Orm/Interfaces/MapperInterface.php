<?php


namespace App\Services\Orm\Interfaces;


interface MapperInterface
{
    public function insert(array $raw): OrmModelInterface;
    public function update(OrmModelInterface $model): bool;
    public function delete(OrmModelInterface $model): bool;
    public function findById(int $id): ?OrmModelInterface;
}
