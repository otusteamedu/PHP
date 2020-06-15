<?php


namespace App\Queue\Items;


abstract class QueueItem
{

    protected function __construct()
    {
    }

    /**
     * @return []
     */
    abstract protected function toArray();

    /**
     * @param [] $data
     * @return bool
     */
    abstract protected function initByArray($data);


    public static function createByArray($data)
    {
        $inst = new static();
        return $inst->initByArray($data) ? $inst: null;
    }


    public function toJson()
    {
        $data = $this->toArray();
        if (!$data)
            return '';
        return json_encode($data);
    }

    public static function createByJson($json)
    {
        $data = json_decode($json, true);
        return static::createByArray($data);
    }
}