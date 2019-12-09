<?php

namespace App\Contracts;

interface Storage
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param string $id
     * @return object|null
     */
    public function getById(string $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data);

    /**
     * @param string $id
     */
    public function delete(string $id): void;

    /**
     * @param string $categoryId
     */
    public function deleteByCategory(string $categoryId): void;

    /**
     * @return mixed
     */
    public function deleteAll(): void;
}
