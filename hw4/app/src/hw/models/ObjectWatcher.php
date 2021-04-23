<?php


namespace VideoPlatform\models;


class ObjectWatcher
{
    /**
     * Current instance of ObjectWatcher
     * @var ObjectWatcher
     */
    private static ObjectWatcher $_instance;

    /**
     * Array of objects to work with.
     * @var array
     */
    private $objects = array();

    /**
     * Getting instance of ObjectWatcher.
     * @return ObjectWatcher
     */
    public static function getInstance(): ObjectWatcher
    {
        if(!isset(self::$_instance)){
            self::$_instance = new ObjectWatcher;
        }
        return self::$_instance;
    }

    /**
     * Getting instance of the object existing in the current application.
     * @param string $className
     * @param int $id
     * @return mixed null or object of the class $className with an id = $id if it exists.
     */
    public static function getRecord(string $className, int $id): mixed
    {
        $inst = self::getInstance();
        $key = "$className.$id";
        if(isset($inst->objects[$key])){
            return $inst->objects[$key];
        }
        return null;
    }

    /**
     * Adding object to ObjectWatcher registry.
     * @param $obj
     * @param int $id
     */
    public static function addRecord($obj, int $id): void
    {
        $inst = self::getInstance();
        $inst->objects[$inst->getKey($obj, $id)] = $obj;
    }

    function getKey($obj, $id): string
    {
        return get_class($obj).'.'.$id;
    }
}
