<?php


namespace Classes\Discounts;


abstract class AbstractDeliveriesCreator
{
    abstract protected function getDelivery(): DeliveryEntity;

    public function getDeliveryPrice()
    {
        $delivery = $this->getDelivery();
        return $delivery->getPrice();
    }
    public function setPackages(array $products)
    {
        $delivery = $this->getDelivery();
        return $delivery->setPackages($products);
    }
}
