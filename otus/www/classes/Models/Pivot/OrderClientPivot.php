<?php

namespace Classes\Models;

class OrderClientPivot extends AbstractActiveRecord
{
    protected $orderId;
    protected $clientId;

    protected static $tableName = 'order_client_pivot';

    public function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function setClientId(int $clientId)
    {
        $this->clientId = $clientId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }
}
