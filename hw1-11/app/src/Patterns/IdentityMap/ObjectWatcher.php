<?php
namespace Src\Patterns\IdentityMap;

/**
 * Class ObjectWatcher
 */
class ObjectWatcher
{
    /**
     * Current instance of ObjectWatcher
     *
     * @var ObjectWatcher
     */
    private static ObjectWatcher $_instance;

    /**
     * Array of objects to work with.
     *
     * @var array
     */
    private $objects = [];

    /**
     * Geting instance of ObjectWatcher.
     *
     * @return ObjectWatcher
     */
    static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Getting instance of the object existing in the current application.
     *
     * @param string $className
     * @param int $id
     *
     * @return mixed null or object of the class $className with an id = $id if it exists.
     */
    public static function getRecord($className, $id)
    {
        $inst = self::getInstance();
        $key = "$className.$id";
        if (isset($inst->objects[$key])) {
            return $inst->objects[$key];
        }
        return null;
    }

    /**
     * Adding object to ObjectWatcher registry.
     *
     * @param $obj
     * @param int $id
     */
    public static function addRecord($obj, $id)
    {
        $inst = self::getInstance();
        $inst->objects[$inst->getKey($obj, $id)] = $obj;
    }

    /**
     * @param $obj
     * @param $id
     *
     * @return string
     */
    public function getKey($obj, $id): string
    {
        return get_class($obj) . '.' . $id;
    }
}