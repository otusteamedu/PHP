<?php

declare(strict_types=1);

namespace App\Kernel\DataBase;

use App\Entity\BaseEntity;
use App\Entity\BaseMetaData;
use App\Kernel\Application;
use Exception;
use PDO;
use PDOStatement;
use ReflectionClass;
use ReflectionException;

class DataMapper
{
    /**
     * @var PDO
     */
    private $db;

    /**
     * @var BaseEntity $entity
     */
    private $entity;

    /**
     * @var string $entityName
     */
    private $entityName;

    /**
     * @var array $entityProperties
     */
    private $entityProperties;

    /**
     * @var BaseMetaData $entityMetaData
     */
    private $entityMetaData;

    /**
     * @throws ReflectionException
     */
    public function __construct($entity)
    {
        $this->db = Application::getCurrent()->getDb();
        $this->entity = $entity;
        $this->entityName = get_class($this->entity);
        
        $metaDataClassName = get_class($entity) . 'MetaData';
        if (!class_exists($metaDataClassName)) {
            throw new Exception("Класс {$metaDataClassName} не существует");
        }
        
        $this->entityMetaData = new $metaDataClassName();
        $this->entityProperties = $this->getEntityProperties($this->entityMetaData);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     * @return DataCollection
     */
    public function find(array $filter): DataCollection
    {
        $findResult = $this->processFilteredQuery($filter);

        $mappingEntities = $this->mappingToEntities($findResult);

        return new DataCollection($mappingEntities);
    }

    /**
     * @param int $id
     * @throws ReflectionException
     * @throws Exception
     * @return BaseEntity
     */
    public function findById(int $id): BaseEntity
    {
        $findResult = $this->processQuery($id);

        return $this->createEntity($findResult);
    }

    /**
     * @throws ReflectionException
     * @var PDOStatement $stm
     * @return array
     */
    public function processFilteredQuery(array $filter): array
    {
        $table = $this->entityMetaData->getTable();

        // Для упрощения будет 'SELECT * '
        $sql = "SELECT * FROM {$table} ";

        $result = null;

        if (!empty($filter)) {
            $sql .= ' WHERE ';
            $sql .= $this->getWhereSql($filter);
            $whereArgs = $this->getWhereArgs($filter);

            $stm = $this->db->prepare($sql);
            $stm->execute($whereArgs);

            $result = $stm->fetchAll();
        } else {
            $stm = $this->db->query($sql);
            $result = $stm->fetchAll();
        }

        return $result;
    }

    /**
     * @throws ReflectionException
     * @var PDOStatement $stm
     * @return array
     */
    public function processQuery(int $id): array
    {
        $table = $this->entityMetaData->getTable();

        // Для упрощения будет 'SELECT * '
        $sql = "SELECT * FROM {$table} WHERE id = ?";

        $stm = $this->db->prepare($sql);
        $stm->execute([$id]);

        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @param BaseMetaData $entity
     * @return array
     * @throws ReflectionException
     */
    public function getEntityProperties(BaseMetaData $entity): array
    {
        $reflectClass = new ReflectionClass($entity);
        $entityPropertiesCollection = $reflectClass->getProperties();
        $resultEntityProperties = [];
        foreach ($entityPropertiesCollection as $property) {
            if ($property->getName() == 'table'
                || $property->getName() == 'entity'
                || $property->getName() == 'repository'
            ) {
                continue;
            }
            $property->setAccessible(true);
            $resultEntityProperties[$property->getName()] = $property->getValue($entity);
        }

        return $resultEntityProperties;
    }


    /**
     * @param array $filter
     * @return string
     */
    public function getWhereSql(array $filter): string
    {
        $sqlWhere = [];
        foreach ($filter as $name => $value) {
            if (is_array($value) && !empty($value)) {
                $inBlock  = str_repeat('?,', count($value) - 1) . '?';
                $whereBlock = " {$name} IN ($inBlock) ";
                $sqlWhere[] = $whereBlock;
            } else {
                $whereBlock = " {$name} = ? ";
                $sqlWhere[] = $whereBlock;
            }
        }

        $resultWhere = implode(' AND ', $sqlWhere);

        return $resultWhere;
    }

    /**
     * @param array $filter
     * @return array
     */
    public function getWhereArgs(array $filter): array
    {
        $whereArgs = [];
        foreach ($filter as $name => $value) {
            if (is_array($value) && !empty($value)) {
                $whereArgs += $value;
            } else {
                $whereArgs[] = $value;
            }
        }
        return $whereArgs;
    }

    /**
     * @param array $findResult
     * @return array
     * @throws Exception
     */
    public function mappingToEntities(array $findResult): array
    {
        $resultEntities = [];
        foreach ($findResult as $row) {
            $resultEntities[] = $this->createEntity($row);
        }

        return $resultEntities;
    }

    /**
     * @param array $row
     * @return BaseEntity
     * @throws Exception
     */
    public function createEntity(array $row): BaseEntity
    {
        /**
         * @var BaseEntity $resultEntity
         */
        $resultEntity = new $this->entityName();

        foreach ($this->entityProperties as $propName => $params) {

            $propDbName = empty($params['table_col']) ? $propName : $params['table_col'] ;

            if (!isset($row[$propDbName]) && !$params['db_nullable']) {
                throw new Exception("В таблице {$this->entityMetaData->getTable()} поле {$propDbName} не содержит обязательное значение");
            }
            if (!isset($row[$propDbName]) && $params['db_nullable']) {
                $resultEntity->setProperty($propName, null);
            }
            if (isset($row[$propDbName])) {
                if (empty($params['reference'])) {
                    $resultEntity->setProperty($propName, $row[$propDbName]);
                } else {
                    /**
                     * @var BaseEntity $proxyEntity
                     */
                    $proxyEntityName = $params['reference'] . 'Proxy';
                    $proxyEntity = new $proxyEntityName();
                    $proxyEntity->setProperty($params['reference_property'], $row[$propDbName]);

                    $resultEntity->setProperty($propName, $proxyEntity);
                    $resultEntity->setProperty($propName, $proxyEntity);
                }
            }

        }

        return $resultEntity;
    }
}
