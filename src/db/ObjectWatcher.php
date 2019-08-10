<?php


namespace hw23\db;

/**
 * Class ObjectWatcher (Identity Map)
 * @package hw23\db
 *
 * @property $object array
 */
class ObjectWatcher
{
    private $objects = [];

    /**
     * @param string $className
     * @param int $id
     * @return mixed|null
     */
    public function getObject(string $className, int $id)
    {
        $key = "{$className}.{$id}";
        if(isset($this->objects[$key])){
            return $this->objects[$key];
        }
        return null;
    }

    /**
     * @param $obj
     * @param $id
     */
    public function addObject($obj, $id)
    {
        $this->objects[get_class($obj) . '.' . $id] = $obj;
    }

}