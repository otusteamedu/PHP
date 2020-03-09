<?php

namespace App\EntityFilter;

abstract class CommonEntityFilter implements IEntityFilter
{
    public const ID = 'id';

    protected int $id = 0;

    /**
     * CommonEntityFilter constructor.
     * @param int|null $id
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id ?? 0;
    }

    /**
     * @param array $row
     * @return IEntityFilter
     */
    public static function buildFromAssoc(array $row): IEntityFilter
    {
        return new static($row[self::ID] ?? null);
    }

    /**
     * @param array|null $assoc
     * @return array
     */
    public function fetchToAssoc(?array $assoc = null): array
    {
        if (!is_array($assoc)) {
            $assoc = [];
        }
        $assoc[self::ID] = $assoc[self::ID] ?? $this->id;
        return $assoc;
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
    public function setId(int $id): IEntityFilter
    {
        $this->id = $id;
        return $this;
    }
}