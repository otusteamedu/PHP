<?php


namespace App\Events;

use App\Order;

class OrderCreated extends Event
{
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
