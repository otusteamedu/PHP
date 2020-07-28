<?php

namespace Classes\Models;

class Discount extends AbstractActiveRecord
{
    protected $id;
    protected $name;
    protected $value;
    protected $type;

    protected static $tableName = 'discounts';
}
