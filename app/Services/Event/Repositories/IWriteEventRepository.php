<?php


namespace App\Services\Event\Repositories;

/**
 * Interface IWriteEventRepository
 * @package App\Services\Event\Repositories
 */
interface IWriteEventRepository
{
    /**
     * Создает новое событие
     *
     * @param array $data
     * @return int
     */
    public function create(array $data): int;

    /**
     * Удаляет событие по $id
     *
     * @param int $id
     * @return bool
     */
    public function delete(string $name): bool;

    /**
     * Удаляет все события
     */
    public function deleteAll(): void;
}
