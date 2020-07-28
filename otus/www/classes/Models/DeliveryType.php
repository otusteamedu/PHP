<?php

namespace Classes\Models;

class DeliveryType extends AbstractActiveRecord
{
    protected $id;
    protected $name;

    protected static $tableName = 'delivery_types';

}
