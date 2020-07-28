<?php

namespace Classes\Models;

class DiscountType extends AbstractActiveRecord
{
    protected $id;
    protected $name;

    protected static $tableName = 'discount_types';
}
