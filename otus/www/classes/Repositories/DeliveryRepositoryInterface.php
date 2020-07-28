<?php

namespace Classes\Repositories;

use Classes\Models\Delivery;

interface DeliveryRepositoryInterface
{
    public function getAllDeliveries(): array;

    public function getDeliveryById(int $id): Delivery;

    public function getDeliveriesWithActiveOrders(): array;
}
