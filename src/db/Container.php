<?php


namespace hw23\db;

/**
 * Class Container
 * @package hw23\db
 */
class Container
{
    /**
     * @param string $classname
     * @param array $params
     * @return mixed
     */
    public static function createObject(string $classname, array $params = [])
    {
        $object = new $classname;
        foreach ($params as $key => $param) {
            if(property_exists($classname, $key)) {
                $object->$key = $param;
            }
        }
        return $object;
    }
}