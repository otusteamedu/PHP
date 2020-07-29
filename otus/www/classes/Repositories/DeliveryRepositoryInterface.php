<?php

namespace Classes\Repositories;

use Classes\Models\Delivery;

interface DeliveryRepositoryInterface
{
    public function getAllDeliveries(): array;

    public function getDeliveryByType(string $type): Delivery;
}
