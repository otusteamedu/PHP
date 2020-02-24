<?php


namespace App\Mappers;


class ProductMapper extends AbstractMapper implements DataMapperInterface
{

    public function findById($id): object
    {
        // TODO: Implement findById() method.
    }

    public function insert(object $entity): int
    {
        // TODO: Implement insert() method.
    }

    public function update(object $entity): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(object $entity): bool
    {
        // TODO: Implement delete() method.
    }

    public function findByType($type): array
    {
        // todo возвращает продукты по типу
        // Для определения типа используется алгоритм Nested Sets
    }

    public function getByOrder($order_id): array
    {
        // todo возвращает продукты заказа
    }
}