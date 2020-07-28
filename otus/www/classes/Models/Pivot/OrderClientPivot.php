<?php

namespace Classes\Models;

class OrderClientPivot extends AbstractActiveRecord
{
    protected $orderId;
    protected $clientId;

    protected static $tableName = 'order_client_pivot';

}
