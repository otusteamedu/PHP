<?php

namespace Tirei01\Hw12;

class CacheObject
{
    private $all = array();
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance() : self
    {
        if(is_null(self::$instance)){
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getIdCache(DomainObject $object) : string {
        $id = get_class($object).'_'.$object->getId();
        return $id;
    }

    public static function add(DomainObject $object)
    {
        $inst = self::getInstance();
        $inst->all[$inst->getIdCache($object)] = $object;
    }

    public static function get(string $className, int $id) : ?DomainObject
    {
        $inst = self::getInstance();
        $id = $className.'_'.$id;
        if(array_key_exists($id, $inst->all)){
            return $inst->all[$id];
        }
        return null;
    }

}