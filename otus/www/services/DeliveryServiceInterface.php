<?php


namespace Services;


interface DeliveryServiceInterface
{

    public function getDeliveryPrice(string $deliveryType);
}
