<?php


namespace App\Events;


use App\Order;
use App\OrderDTO;

class OrderUpdated extends Event
{
    public Order $order;
    public OrderDTO $newOrder;

    public function __construct(Order $order, OrderDTO $newOrder)
    {
        $this->order = $order;
        $this->newOrder = $newOrder;
    }
}
