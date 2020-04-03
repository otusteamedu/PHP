<?php

declare(strict_types=1);

namespace App\DataBase;

use App\Entity\BaseEntity;

interface DataMapperInterface
{
    public function find(array $filter): DataCollection;

    public function findById(int $id): BaseEntity;

    public function mappingToEntities(array $findResult): array;

    public function createEntity(array $row): BaseEntity;
}
