<?php

namespace Classes\Repositories;

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

    public function getDeliveryById(int $id)
    {
        // TODO: Implement getDeliveryById() method.
    }

    public function getDeliveriesWithActiveOrders(): array
    {
        // TODO: Implement getDeliveriesWithActiveOrders() method.
    }
}
