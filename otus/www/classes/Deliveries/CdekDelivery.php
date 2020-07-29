<?php


namespace Classes\Discounts;


class CdekDelivery implements DeliveryEntity
{

    const DEFAULT_DELIVERY_VALUE = 100;

    public function getValue()
    {
       return self::DEFAULT_DELIVERY_VALUE;
    }
}

