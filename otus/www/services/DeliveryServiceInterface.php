<?php


namespace Services;


use Classes\Models\Product;

interface DeliveryServiceInterface
{
    public function getDeliveryPrice(string $deliveryType);

}
