<?php

namespace Repository;

use Filter\EventsFilter;
use Filter\RedisFilter;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class EventsRepository extends RedisRepository
{
    private const EXCLUDED_PROPERTIES = ["exists", "id"];
    private const SCORES_KEY = "scores";

    /** @var array $conditions */
    protected array $conditions = [];

    /** @var int $priority */
    protected int $priority = 0;

    public function buildFromArray(array $row)
    {
        parent::buildFromArray($row);

        $this->conditions = EventsFilter::parseConditions($row);
    }

    /**
     * @param RedisFilter $filter
     * @return static[]
     */
    public static function get($filter): array
    {
        $entitiesKeys = self::getFilteredRepositoryKeys($filter);
        return array_map(function ($entityKey) {
            $document = self::$store->hGetAll($entityKey);
            $entity = new static();
            return $entity->buildFromDocument($document);
        }, $entitiesKeys);
    }

    /**
     * @param RedisFilter $filter
     * @return static
     */
    public static function getByMaxPriority(RedisFilter $filter)
    {
        $entitiesKeys = self::getFilteredRepositoryKeys($filter);
        $ranks = [];
        foreach ($entitiesKeys as $key) {
            $ranks[$key] = self::$store->zRank(self::SCORES_KEY, $key);
        }
        if (!empty($ranks)) {
            $entityKey = array_search(max($ranks), $ranks);
            $document = self::$store->hGetAll($entityKey);
            $entity = new static();
            return $entity->buildFromDocument($document);
        }
        return new static();
    }

    /**
     * @param RedisFilter $filter
     * @return array
     */
    public static function fetchList($filter): array
    {
        return array_map(function (RedisRepository $entity) {
            return $entity->fetchDocument();
        }, static::get($filter));
    }

    public function fetchDocument(): array
    {
        $document = [];
        try {
            $reflect = new ReflectionClass(static::class);
            foreach ($reflect->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC) as $property) {
                if ($property->isStatic() || in_array($property->getName(), self::EXCLUDED_PROPERTIES)) continue;
                $selfValue = $this->{$property->getName()};
                if (empty($selfValue) && !is_string($selfValue) && !is_bool($selfValue)) continue;
                $document[$property->getName()] = is_array($selfValue) ? json_encode($selfValue) : $selfValue;
            }
        } catch (ReflectionException $e) {
        }
        return $document;
    }

    /**
     * @param mixed $document
     * @return static
     */
    protected function buildFromDocument($document): EventsRepository
    {
        try {
            $reflect = new ReflectionClass(static::class);
            foreach ($reflect->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC) as $property) {
                if ($property->isStatic()) continue;
                if (is_null($documentValue = $document[$property->getName()] ?? null)) continue;
                $value = $this->{$property->getName()};
                if (is_bool($value)) {
                    $this->{$property->getName()} = boolval($documentValue);
                } elseif (is_float($value)) {
                    $this->{$property->getName()} = floatval($documentValue);
                } elseif (is_int($value)) {
                    $this->{$property->getName()} = intval($documentValue);
                } elseif (is_array($value)) {
                    $this->{$property->getName()} = json_decode($documentValue, JSON_OBJECT_AS_ARRAY) ?: [$documentValue];
                } else {
                    $this->{$property->getName()} = $documentValue;
                }
            }
            $this->exists = true;
        } catch (ReflectionException $e) {
        }
        return $this;
    }

    public static function deleteCollection($filter): int
    {
        return intval(self::$store->flushDB());
    }

    public function create(): bool
    {
        self::$store->hMSet($this->getRepositoryHashKey(), $this->fetchDocument());
        self::$store->zAdd(self::SCORES_KEY, ['NX'], $this->getPriority(), $this->getRepositoryHashKey());
        return $this->exists;
    }

    public function update(): bool
    {
        return false;
    }

    public function delete(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    final protected function getRepositoryHashKey(): string
    {
        return implode(":", [self::getRepositoryKey(), self::getEntityConditionKey($this->conditions), $this->getKey()]);
    }

    final protected static function getRepositoryKey(): string
    {
        return md5(static::class);
    }

    /**
     * @param $conditions
     * @return string
     */
    final public static function getEntityConditionKey($conditions): string
    {
        $conditions = array_map(function ($val) {
            return (string)$val;
        }, $conditions);
        ksort($conditions);
        return md5(serialize($conditions));
    }

    /**
     * @param RedisFilter $filter
     * @return string[]
     */
    final private static function getFilteredRepositoryKeys(RedisFilter $filter): array
    {
        if (empty($filter->fetch())) {
            return self::$store->keys(self::getRepositoryKey() . ":*");
        }
        return self::$store->keys(self::getRepositoryKey() . ':' . $filter->getHashKey() . '*');
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return string
     */
    public function getConditionsAsString(): string
    {
        return http_build_query($this->conditions, null, ",");
    }

    /**
     * @param array $conditions
     */
    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}