<?php

namespace Classes\Models;

class ProductPackagePivot extends AbstractActiveRecord
{
    protected $orderId;
    protected $packageId;

    protected static $tableName = 'product_package_pivot';

}
