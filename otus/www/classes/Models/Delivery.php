<?php

namespace Classes\Models;

class Delivery extends AbstractActiveRecord
{
    protected $id;
    protected $name;
    protected $type;
    protected $cost;

    protected static $tableName = 'delivery';

    public function getName()
    {
        return $this->name;
    }
    public function getType()
    {
        return $this->type;
    }

    public function getCost()
    {
        return $this->cost;
    }

}
