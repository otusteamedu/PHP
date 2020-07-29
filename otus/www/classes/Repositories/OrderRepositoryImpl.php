<?php

namespace Classes\Repositories;

use Classes\Models\Order;

class OrderRepositoryImpl implements OrderRepositoryInterface
{
    public function getAllOrders(): array
    {
        // TODO: Implement getAllOrders() method.
    }

    public function getOrderById(int $id):Order
    {
        // TODO: Implement getOrderById() method.
    }

    public function getOrderByNumber(int $number):Order
    {
        // TODO: Implement getOrderByNumber() method.
    }

    public function getOrderByType(int $type):Order
    {
        // TODO: Implement getOrderByType() method.
    }

    public function getOrdersWithDiscounts(): array
    {
        // TODO: Implement getOrdersWithDiscounts() method.
    }

    public function getOrdersWithDeliveries(): array
    {
        // TODO: Implement getOrdersWithDeliveries() method.
    }

    public function getOrderByStatus(string $status): Order
    {
        // TODO: Implement getOrderByStatus() method.
    }

    public function getOrdersConstOver(string $cost): array
    {
        // TODO: Implement getOrdersConstOver() method.
    }

    public function saveOrder(Order $order)
    {
        try {
            $order->save();
        }
        catch (\Exception $exception) {
            //TODO реализовать логирование
            return $exception->getMessage();
        }

        return $order->getId() ;

    }

    public function deleteOrder(int $orderId)
    {
        $order = $this->getOrderById($orderId);
        if (!$order) {
            return false;
        }

        $order::delete($orderId);
    }
}
