<?php

declare(strict_types=1);

namespace App\Entity;

class BaseMetaData
{
    public function getTable(): string
    {
        return $this->table;
    }

    public function getRepository(): object
    {
        $repositoryName = $this->repository;

        return new $repositoryName();
    }
}