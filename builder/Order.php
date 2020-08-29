<?php

namespace \Builder;

class Order {
    private $order;
    private $delivery;

    public function __construct(array $order, object $delivery) 
    {
        $this->order = $order ?? null;
        $this->delivery = $delivery ?? null;
    }

    // тут будет несколько приватных методов которые будут собрирать из заказа и доставки
    
    public function getJson()
    {
        //  ...

        return json_encode(...);
    }

    public function getArray() : Array
    {
        //  ...

        return json_encode(...);
    }
}
