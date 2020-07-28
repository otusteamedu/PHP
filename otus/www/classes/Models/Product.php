<?php

namespace Classes\Models;

class Product extends AbstractActiveRecord
{
    protected $id;
    protected $name;

    protected static $tableName = 'products';

    public function getName()
    {
        return $this->name;
    }
}
