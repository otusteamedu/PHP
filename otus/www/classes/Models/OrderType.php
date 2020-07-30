<?php

namespace Classes\Models;

class OrderType extends AbstractActiveRecord
{
    protected $id;
    protected $name;

    protected static $tableName = 'order_type';

    public function getName()
    {
        return $this->name;
    }

}
