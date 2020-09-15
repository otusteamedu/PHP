<?php


namespace Controllers\Contracts;


use Models\Orders\Order;

interface OrdersInterface
{
    public function setOrder(Order $order): Order;
    public function setOrderIsPaid(Order $order): bool;
}