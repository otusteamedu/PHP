<?php


namespace SysEvents;


class Condition
{
    private $params = [];

    public function __construct($conditions = [])
    {
        if (!empty($conditions))
            $this->add($conditions);
    }

    public function add($conditions)
    {
        foreach ($conditions as $param => $val)
            $this->params[$param] = $val;
    }

    public function toArray()
    {
        return $this->params;
    }

    public function validate($conditions)
    {
        //$intersec = array_intersect_assoc($this->params, $conditions);
        return $this->params == $conditions;
    }



}