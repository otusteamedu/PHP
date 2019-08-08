<?php
/**
* Realization of Identity Map pattern
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Main;

use Jekys\Abstraction\Singleton;

class IdentityMap extends Singleton
{
    /**
    * @var array - storage for already loaded objects
    */
    private static $objects = [];

    /**
    * Checks object existance
    *
    * @param string $className
    * @param mixed $key
    *
    * @return bool
    */
    public function isObjectExists(string $className, $key): bool
    {
        if (array_key_exists($className, self::$objects)
            && array_key_exists($key, self::$objects[$className])
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Returs object if exists
    *
    * @param string $className
    * @param mixed $key
    *
    * @return null|object
    */
    public function getObject(string $className, $key): ?object
    {
        $object = null;
        if ($this->isObjectExists($className, $key)) {
            $object = self::$objects[$className][$key];
        }

        return $object;
    }

    /**
    * Save object to the storage
    *
    * @param object $object
    * @param mixed $key
    *
    * @return void
    */
    public function registerObject(object $object, $key): void
    {
        $className = get_class($object);
        self::$objects[$className][$key] = $object;
    }

    /**
    * Delete object from storage
    *
    * @param string $className
    * @param mixed $key
    *
    * @return void
    */
    public function deleteObject(string $className, $key): void
    {
        if ($this->isObjectExists($className, $key)) {
            unset(self::$objects[$className][$key]);
        }
    }
}
