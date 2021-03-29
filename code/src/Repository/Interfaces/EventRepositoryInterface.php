<?php


namespace App\Repository\Interfaces;


use App\Model\Interfaces\ModelEventInterface;

interface EventRepositoryInterface
{
    public function create(ModelEventInterface $model): ModelEventInterface;
    public function findOne(int $id): ModelEventInterface;
    /**
     * @return ModelEventInterface[]
     */
    public function findAll(): array;
    /**
     * @param array $params
     * @return ModelEventInterface[]
     */
    public function findByParams(array $params): array;
    public function drop(): bool;
}
