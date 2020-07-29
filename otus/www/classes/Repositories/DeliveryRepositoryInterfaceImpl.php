<?php

namespace Classes\Repositories;

use Classes\Models\Delivery;

class DeliveryRepositoryInterfaceImpl implements DeliveryRepositoryInterface
{
    private $dbClient;

    public function __construct($dbClient)
    {
        $this->dbClient = $dbClient;
    }

    public function getAllDeliveries(): array
    {
        // TODO: Implement getAllDeliveries() method.
    }

    public function getDeliveryByType(string $type) :Delivery
    {
        // TODO: Implement getDeliveryById() method.
    }

    public function getDeliveriesWithActiveOrders(): array
    {
        // TODO: Implement getDeliveriesWithActiveOrders() method.
    }
}
