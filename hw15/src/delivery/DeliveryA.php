<?php


namespace App\delivery;


class DeliveryA extends Delivery
{
    public function __construct()
    {
        $id = 1;
        $price = 50.0;
        parent::__construct($id, $price);
    }

}