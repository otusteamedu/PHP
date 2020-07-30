<?php

namespace Classes\Repositories;

use Classes\Models\Order;

interface OrderRepositoryInterface
{
    public function saveOrder(Order $order): int;

    public function deleteOrder(int $orderId): bool;

    public function getOrderById(int $id) :Order;
}
