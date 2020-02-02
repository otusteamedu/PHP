<?php

declare(strict_types=1);

namespace App\Entity;

use ReflectionClass;
use ReflectionException;

class BaseProxy extends BaseEntity
{
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @throws ReflectionException
     */
    public function getProperty($name)
    {
        if (!empty($this->$name)) {
            return $this->$name;
        }

        $currentClass = get_class($this);
        $metaDataClassName = str_replace('Proxy', 'MetaData', $currentClass);
        
        if (!class_exists($metaDataClassName)) {
            throw new Exception("Класс {$metaDataClassName} не существует");
        }
        
        $metaData = new $metaDataClassName();

        $repository = $metaData->getRepository();

        $realObject = $repository->findByid($this->getId());

        $reflectClass = new ReflectionClass($realObject);
        $entityPropertiesCollection = $reflectClass->getProperties();
        foreach ($entityPropertiesCollection as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($realObject);

            if (!empty($this->$propertyName)) {
                continue;
            }
            if ($this->$propertyName != $propertyValue) {
                $this->setProperty($propertyName, $propertyValue);
            }
        }

        return $this->$name;
    }
}
