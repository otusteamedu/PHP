<?php

namespace Classes\Models;

class OrderProductPivot extends AbstractActiveRecord
{
    protected $orderId;
    protected $productId;

    protected static $tableName = 'order_product_pivot';

}
