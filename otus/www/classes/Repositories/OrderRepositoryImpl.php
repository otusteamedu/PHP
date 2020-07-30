<?php

namespace Classes\Repositories;

use Classes\Models\Order;

class OrderRepositoryImpl implements OrderRepositoryInterface
{
    public function getOrderById(int $id):Order
    {
        // TODO: Implement getOrderById() method.
    }

    public function saveOrder(Order $order): int
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

    public function deleteOrder(int $orderId): bool
    {
        $order = $this->getOrderById($orderId);
        if (!$order) {
            return false;
        }

        $order::delete($orderId);
        return true;
    }
}
