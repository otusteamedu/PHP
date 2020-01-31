<?php

namespace Core;

use ReflectionObject;
use ReflectionProperty;

abstract class RowStructureObject
{
    /** @var static[] */
    private static array $store = [];

    /** @var bool $exists */
    private $exists = false;

    /**
     * RowStructureStore constructor.
     * @param array|null $row
     */
    final public function __construct(?array $row = null)
    {
        $this->build($row ?? self::$store[static::class] ?? []);
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return $this->exists;
    }

    /**
     * @param array $row
     */
    protected function build(array $row)
    {
        $this->exists = !empty($row);
        $self = new ReflectionObject($this);
        $selfProperties = $self->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
        foreach ($selfProperties as $selfProperty) {
            $propName = self::decodeKey($selfProperty->getName());
            $val = $row[$propName] ?? $this->{$selfProperty->getName()};
            $this->{$selfProperty->getName()} = $val;
        }
        self::$store[static::class] = $row;
    }

    /**
     * @param string $key
     * @return string
     */
    private static function decodeKey(string $key): string
    {
        preg_match_all('/[A-Z]/', $key, $matches);
        foreach ($matches[0] ?? [] as $match) {
            $key = str_replace($match, "_" . strtolower($match), $key);
        }
        return $key;
    }
}