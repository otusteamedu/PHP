<?php

namespace Classes\Repositories;

use Classes\Models\Order;

interface OrderRepositoryInterface
{

    public function saveOrder(Order $order);

    public function deleteOrder(int $orderId);

    public function getAllOrders(): array;

    public function getOrderById(int $id) :Order;

    public function getOrderByNumber(int $number) :Order;

    public function getOrderByType(int $type): Order;

    public function getOrderByStatus(string $status): Order;

    public function getOrdersWithDiscounts(): array;

    public function getOrdersWithDeliveries(): array;

    public function getOrdersConstOver(string $cost): array;
}
