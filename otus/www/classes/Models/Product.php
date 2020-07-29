<?php

namespace Classes\Models;

class Product extends AbstractActiveRecord
{
    protected $id;
    protected $name;
    protected $weight;

    protected static $tableName = 'products';

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
