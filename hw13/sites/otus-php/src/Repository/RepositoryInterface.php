<?php

declare(strict_types=1);

namespace App\Repository;

interface RepositoryInterface
{
    public function find(array $filter): iterable;

    public function findById(int $id): object;
}