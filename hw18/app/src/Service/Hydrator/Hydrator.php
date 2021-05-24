<?php

declare(strict_types=1);

namespace App\Service\Hydrator;

use ReflectionException;
use ReflectionClass;
use ReflectionProperty;

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
     */
    public function hydrateProperty(object $targetEntity, string $propertyName, $value): object
    {
        $entity = clone $targetEntity;

        $reflectionClass = $this->getReflectionClass(get_class($entity));

        $property = $this->getPropertyFromReflectionClass($reflectionClass, $propertyName);

        $property->setValue($entity, $value);

        return $entity;
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