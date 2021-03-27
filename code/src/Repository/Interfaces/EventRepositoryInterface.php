<?php


namespace App\Repository\Interfaces;


use App\Model\Interfaces\EventInterface;

interface EventRepositoryInterface
{
    public function create(EventInterface $model): EventInterface;
    public function findOne(int $id): EventInterface;
    /**
     * @return EventInterface[]
     */
    public function findAll(): array;
    /**
     * @param array $params
     * @return EventInterface[]
     */
    public function findByParams(array $params): array;
    public function drop(): bool;
}
