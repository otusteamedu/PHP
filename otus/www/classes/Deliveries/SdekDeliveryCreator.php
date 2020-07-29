<?php


namespace Classes\Discounts;


class SdekDeliveryCreator extends AbstractDeliveriesCreator
{

    protected function getDelivery(): DeliveryEntity
    {
        return new CdekDelivery();
    }
}

