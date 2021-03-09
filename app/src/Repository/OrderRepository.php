<?php

namespace Otus\Repository;

use Otus\Model\Order;

class OrderRepository
{
    private array $orderData;

    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    public function save()
    {
        $order = new Order();
        $order->setCardNumber($this->orderData['card_number']);
        $order->setCardHolder($this->orderData['card_holder']);
        $order->setCardExpiration($this->orderData['card_expiration']);
        $order->setCvv($this->orderData['cvv']);
        $order->setOrderNumber($this->orderData['order_number']);
        $order->setSum($this->orderData['sum']);
        $order->setIsPaid(true);
        $order->setAdditionalData($this->orderData['additional_data']);

        $order->save();
    }
}