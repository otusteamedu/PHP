<?php


namespace Classes\Discounts;


interface DeliveryEntity
{
    public function getPrice();

    public function setPackages(array $products);
}
