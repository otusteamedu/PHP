<?php

namespace Otus\Models;

/**
 * Singleton
 * Class IdentityMap
 * @package Otus
 */
class IdentityMap
{
    /**
     * instance of class
     * @var
     */
    private static $_instance;

    /**
     * Array of objects to work with.
     * @var array
     */
    private $objects = array();

    /**
     * Geting instance of IdentityMap.
     * @return IdentityMap
     */
    static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new IdentityMap;
        }
        return self::$_instance;
    }

    /**
     * Getting instance of the object existing in the current application.
     * @param string $className
     * @param int $id
     * @return mixed null or object of the class $className with an id = $id if it exists.
     */
    static function getRecord($className, $id)
    {
        $inst = self::getInstance();
        $key = "$className.$id";
        if (isset($inst->objects[$key])) {
            return $inst->objects[$key];
        }
        return null;
    }

    /**
     * Adding object to IdentityMap registry.
     * @param $obj
     * @param int $id
     */
    static function addRecord($obj, $id)
    {
        $inst = self::getInstance();
        $inst->objects[$inst->getKey($obj, $id)] = $obj;
    }

    /**
     * Generating keyName by object
     * @param $obj
     * @param $id
     * @return string
     */
    function getKey($obj, $id)
    {
        return get_class($obj) . '.' . $id;
    }
}