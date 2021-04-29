<?php

declare(strict_types=1);

namespace App\Service;

class IdentityMap
{
    private array $entities = [];

    public function get(string $entityClassName, string $entityId): ?object
    {
        if (empty($this->entities[$entityClassName][$entityId])) {
            return null;
        }

        return $this->entities[$entityClassName][$entityId];
    }

    public function set(object $entity, string $entityId): void
    {
        $entityClassName = get_class($entity);

        $this->entities[$entityClassName][$entityId] = $entity;
    }

    public function delete(object $entity, string $entityId): void
    {
        $entityClassName = get_class($entity);

        unset($this->entities[$entityClassName][$entityId]);
    }
}