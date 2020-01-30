<?php

namespace Repository;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class CommonRepository implements EntityRepositoryInterface
{
    /** @var string $id */
    protected string $id = "";

    /** @var bool $exists */
    protected bool $exists = false;

    /**
     * @param mixed $document
     * @return CommonRepository
     */
    abstract protected function buildFromDocument($document): CommonRepository;

    public static function getInstanceByRequest(): CommonRepository
    {
        $self = new static();
        $self->buildFromArray($_POST);
        $self->exists = false;
        return $self;
    }

    /**
     * @param array $row
     */
    protected function buildFromArray(array $row)
    {
        foreach ($row as $propName => $propValue) {
            if (!property_exists(static::class, $propName)) continue;
            if (is_array($this->$propName) && is_string($propValue)) {
                $this->$propName = json_decode($propValue) ?: [];
            } else {
                $this->$propName = $propValue;
            }
        }
    }

    /**
     * @param CommonRepository $entity
     */
    final protected function init(?CommonRepository $entity = null)
    {
        if ($entity instanceof CommonRepository) {
            try {
                $reflect = new ReflectionClass(static::class);
                $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
                foreach ($properties as $property) {
                    if ($property->isStatic()) continue;
                    $this->{$property->getName()} = $entity->{$property->getName()};
                }
            } catch (ReflectionException $e) {
            }
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return $this->exists;
    }
}