<?php

namespace models;

class Delivery
{
    public $name;

    public function addOrder(Order $order){

    }

    public function calcCost(){
        return random_int(100,1000);
    }
}