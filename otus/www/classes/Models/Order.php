<?php

namespace Classes\Models;

class Order extends AbstractActiveRecord
{
    protected $id;
    protected $number;
    protected $cost;
    protected $product;
    protected $type;

    protected static $tableName = 'orders';

}
