<?php

namespace Filter;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class CommonFilter
{
    public const ID = "id";

    /** @var mixed $id */
    private $id;

    /**
     * CommonFilter constructor.
     * @param string|int|array|null $filter
     */
    public function __construct($filter = null)
    {
        if (is_scalar($filter)) {
            $this->id = $filter;
        } elseif (is_array($filter)) {
            $this->buildFromArray($filter);
        }
    }

    /**
     * @return static
     */
    public static function initByRequest(): CommonFilter
    {
        $self = new static();
        $self->buildFromArray($_GET);
        return $self;
    }

    /**
     * @return array
     */
    abstract public function fetch(): array;

    /**
     * @param array $rowFilter
     */
    protected function buildFromArray(array $rowFilter)
    {
        try {
            $reflect = new ReflectionClass(static::class);
            $selfProperties = $reflect->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
            foreach ($selfProperties as $selfProperty) {
                if ($selfProperty->isStatic() || !array_key_exists($selfProperty->getName(), $rowFilter)) continue;
                $selfValue = &$this->{$selfProperty->getName()};
                $filterVal = $rowFilter[$selfProperty->getName()];
                if (empty($filterVal) && !is_bool($filterVal) && is_int($filterVal)) continue;
                if (is_bool($selfValue)) {
                    $selfValue = boolval($filterVal);
                } elseif (is_int($selfValue)) {
                    $selfValue = intval($filterVal);
                } else {
                    $selfValue = $filterVal;
                }
            }
        } catch (ReflectionException $e) {
        }
    }

    /**
     * @param mixed $id
     * @return CommonFilter
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}