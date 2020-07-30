<?php

namespace Classes\Models;

class Discount extends AbstractActiveRecord
{
    protected $id;
    protected $name;
    protected $value;
    protected $type;

    protected static $tableName = 'discounts';

    public function getName()
    {
        return $this->name;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }
}
