<?php

declare(strict_types=1);

namespace App\Kernel;

use App\DataBase\DataCollection;
use ReflectionClass;
use ReflectionException;
use stdClass;

class Response implements ResponseInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @throws ReflectionException
     */
    public function send($debug = false)
    {
        if ($debug) {
            echo '<pre>';
            var_dump($this->data);
        } elseif ($this->data instanceof DataCollection) {
            $this->data = $this->getObjectsWithAllProperities();

            header('Content-Type: application/json; charset=utf-8');

            echo json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * @throws ReflectionException
     */
    public function getObjectsWithAllProperities(): array
    {
        $result = [];
        foreach ($this->data as $object) {
            $result[] = $this->getUnPrivateObject($object);
        }

        return $result;
    }

    /**
     * @throws ReflectionException
     */
    public function getUnPrivateObject($object): object
    {
        $unPrivateObject = new stdClass();
        $reflectClass = new ReflectionClass($object);
        $entityPropertiesCollection = $reflectClass->getProperties();
        foreach ($entityPropertiesCollection as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($object);

            if (is_object($propertyValue)) {
                $objectProperty = $this->getUnPrivateObject($propertyValue);

                $unPrivateObject->$propertyName = $objectProperty;
            } else {
                $unPrivateObject->$propertyName = $propertyValue;
            }
        }

        return $unPrivateObject;
    }
}
