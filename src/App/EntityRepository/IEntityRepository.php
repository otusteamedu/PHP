<?php

namespace App\EntityRepository;

use App\EntityInterface\IEntity;
use App\EntityFilter\IEntityFilter;
use PDO;

interface IEntityRepository
{
    /**
     * возвращает из хранилища сведения о сущности по фильтру
     * @param PDO           $pdo
     * @param IEntityFilter $filter
     * @return IEntity[]
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array;

    /**
     * сохранение в БД сведений о сущности $entity
     * @param IEntity $entity
     * @return bool
     */
    public function create(IEntity $entity): bool;

    /**
     * обновление в БД сведений о сущности $entity
     * @param IEntity $entity
     * @return bool
     */
    public function update(IEntity $entity): bool;

    /**
     * удаление из БД сведений о сущности $entity
     * @param IEntity $entity
     * @return bool
     */
    public function delete(IEntity $entity): bool;
}