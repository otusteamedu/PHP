<?php

declare(strict_types=1);

namespace App\Service\Hydrator;

use DateTimeImmutable;
use Exception;
use ReflectionException;
use ReflectionClass;
use ReflectionProperty;
use ReflectionType;

class Hydrator implements HydratorInterface
{
    private array $reflectionClassMap = [];

    /**
     * @param object|string $entityOrEntityClassName
     *
     * @throws ReflectionException
     */
    public function hydrate($entityOrEntityClassName, array $data): object
    {
        if (is_object($entityOrEntityClassName)) {
            $entity = clone $entityOrEntityClassName;
        } else {
            $reflectionClass = $this->getReflectionClass($entityOrEntityClassName);
            $entity = $reflectionClass->newInstanceWithoutConstructor();
        }

        foreach ($data as $fieldName => $value) {
            $propertyName = $fieldName;

            $entity = $this->hydrateProperty($entity, $propertyName, $value);
        }

        return $entity;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function hydrateProperty(object $targetEntity, string $propertyName, $value): object
    {
        $entity = clone $targetEntity;

        $reflectionClass = $this->getReflectionClass(get_class($entity));

        $property = $this->getPropertyFromReflectionClass($reflectionClass, $propertyName);

        $property->setValue($entity, $this->performTypeConversions($value, $property->getType()));

        return $entity;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     * @throws Exception
     */
    private function performTypeConversions($value, ReflectionType $type)
    {
        if ($type->getName() === 'DateTimeImmutable') {
            return new DateTimeImmutable($value);
        }

        return $value;
    }

    /**
     * @throws ReflectionException
     */
    private function getReflectionClass(string $className): ReflectionClass
    {
        if (isset($this->reflectionClassMap[$className])) {
            return $this->reflectionClassMap[$className];
        }

        return $this->reflectionClassMap[$className] = new ReflectionClass($className);
    }

    /**
     * @throws ReflectionException
     */
    private function getPropertyFromReflectionClass(
        ReflectionClass $reflectionClass,
        string $propertyName
    ): ReflectionProperty {
        $property = $reflectionClass->getProperty($propertyName);

        if ($property->isPrivate() or $property->isProtected()) {
            $property->setAccessible(true);
        }

        return $property;
    }
}