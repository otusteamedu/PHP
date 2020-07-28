<?php

namespace Classes\Models;

class Delivery extends AbstractActiveRecord
{
    protected $id;
    protected $name;
    protected $type;
    protected $cost;

    protected static $tableName = 'delivery';

}
