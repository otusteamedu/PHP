<?php


namespace App\Queue;


abstract class QueueObject
{
    abstract protected function toArray();

    abstract protected function initByArray($data);

    public static function createByArray($data)
    {
        $inst = new static();
        return $inst->initByArray($data) ?? $inst;
    }

    public static function createByJson($json)
    {
        $data = json_decode($json, true);
        return static::createByArray($data);
    }
}