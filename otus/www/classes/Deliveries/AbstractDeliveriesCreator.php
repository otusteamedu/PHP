<?php


namespace Classes\Discounts;


abstract class AbstractDeliveriesCreator
{
    abstract protected function getDelivery(): DeliveryEntity;

    public function getDeliveryPrice()
    {
        $discount = $this->getDelivery();
        return $discount->getValue();
    }
}
