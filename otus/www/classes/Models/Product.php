<?php

namespace Classes\Models;

class Product extends AbstractActiveRecord
{
    protected $id;
    protected $name;

    protected static $tableName = 'products';
}
