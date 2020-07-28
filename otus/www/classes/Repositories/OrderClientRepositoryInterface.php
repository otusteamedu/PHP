<?php


namespace Classes\Repositories;


use Classes\Models\OrderClientPivot;

interface OrderClientRepositoryInterface
{
    public function save(OrderClientPivot $orderClientPivot);

    public function deleteAllRowsByOrderId(int $orderId);

    public function deleteAllRowsByClientId(int $clientId);
}
