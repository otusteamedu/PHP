<?php

declare(strict_types=1);

namespace App\Entity;

class BaseMetaData
{
    public function getTable(): string
    {
        return $this->table;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function getRepository(): object
    {
        $repositoryName = $this->repository;
        $entityClass = $this->getEntity();
        $entity = new $entityClass();

        return new $repositoryName($entity);
    }
}