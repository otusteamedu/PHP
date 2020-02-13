<?php

namespace App\Entity;

use App\Entity\Filter\IFilters;
use PDO;

abstract class Entity implements IEntities
{
    private int $id = 0;

    protected ?PDO $pdo;

    /**
     * @var static[]
     */
    protected static array $cache = [];

    protected static string $selectQuery = '';

    /**
     * Entity constructor.
     * @param PDO|null $pdo
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function isExists(): bool
    {
        return boolval($this->id);
    }

    /**
     * @param PDO      $pdo
     * @param IFilters $filter
     * @return Movie[]
     */
    public static function getByFilter(PDO $pdo, IFilters $filter): array
    {
        $st = $pdo->prepare(static::$selectQuery);
        if ($st->execute($filter->fetch())) {
            return array_map(
                fn(array $row) => static::initByRow($pdo, $row),
                $st->fetchAll()
            );
        }
        return [];
    }

    /**
     * @param Entity $self
     * @return static
     */
    protected static function putCache(Entity $self): self
    {
        static::$cache[static::getCacheKey($self->getId())] = $self;
        return $self;
    }

    /**
     * @param int $id
     * @return Entity|null
     */
    protected static function getCache(int $id): ?Entity
    {
        return static::$cache[static::getCacheKey($id)] ?? null;
    }

    /**
     * @param static $self
     * @return static
     */
    protected static function popCache(Entity $self): self
    {
        unset(static::$cache[static::getCacheKey($self->getId())]);
        return $self;
    }

    /**
     * @param int $id
     * @return string
     */
    private static function getCacheKey(int $id): string
    {
        return md5(static::class) . $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return static
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}