<?php

namespace App\EntityInterface;

use App\EntityFilter\IEntityFilter;
use PDO;

interface IEntity
{
    /**
     * @param PDO           $pdo
     * @param IEntityFilter $filter
     * @return IEntity[]
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array;

    /**
     * @param PDO $pdo
     * @param int $id
     * @return IEntity
     */
    public static function getById(PDO $pdo, int $id): IEntity;

    /**
     * @return bool
     */
    public function create(): bool;

    /**
     * @return bool
     */
    public function update(): bool;

    /**
     * @return bool
     */
    public function delete(): bool;

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self;
}