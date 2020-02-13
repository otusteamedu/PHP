<?php

namespace App\Entity\Filter;

use ReflectionException;
use ReflectionObject;

abstract class EntityFilter implements IFilters
{
    public const ID = 'id';

    protected string $id = '';

    /**
     * EntityFilter constructor.
     * @param int|array|null $filter
     */
    public function __construct($filter = null)
    {
        if (is_array($filter)) {
            $this->build($filter);
        } elseif (is_numeric($filter)) {
            $this->id = (string)$filter;
        } elseif (is_null($filter)) {
            $this->build($_GET);
        }
    }

    /**
     * @param array $row
     */
    public function build(array $row)
    {
        try {
            $properties = (new ReflectionObject($this))->getProperties();
            foreach ($properties as $property) {
                if ($property->isStatic()) {
                    continue;
                }
                $property->setAccessible(true);
                $property->setValue(
                    $this,
                    $row[self::key($property->getName())] ?? ''
                );
            }
        } catch (ReflectionException $e) {
        }
    }

    /**
     * @return array
     */
    public function fetch(): array
    {
        $row = [];
        try {
            $properties = (new ReflectionObject($this))->getProperties();
            foreach ($properties as $property) {
                if ($property->isStatic()) {
                    continue;
                }
                $property->setAccessible(true);
                $row[self::key($property->getName())] = $property->getValue(
                    $this
                );
            }
        } catch (ReflectionException $e) {
        }
        return $row;
    }

    /**
     * @param string $key
     * @return string
     */
    private static function key(string $key): string
    {
        preg_match_all('/[A-Z]/', $key, $search);
        $replace = array_map(fn($s) => '_' . strtolower($s), $search[0]);
        return str_replace($search[0], $replace, $key);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return EntityFilter
     */
    public function setId(string $id): EntityFilter
    {
        $this->id = $id;
        return $this;
    }

}