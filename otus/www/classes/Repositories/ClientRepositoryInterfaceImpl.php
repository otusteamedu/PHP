<?php

namespace Classes\Repositories;

use Classes\Models\Client;

class ClientRepositoryInterfaceImpl implements ClientRepositoryInterface
{
    private $dbClient;

    public function __construct($dbClient)
    {
        $this->dbClient = $dbClient;
    }

    public function getAllClients(): array
    {
        // TODO: Implement getAllClients() method.
    }

    public function getClientById(int $id): Client
    {
        // TODO: Implement getClientById() method.
    }

    public function getClientByName(int $id): Client
    {
        // TODO: Implement getClientByName() method.
    }

    public function getClientByAddress(int $id): Client
    {
        // TODO: Implement getClientByAddress() method.
    }

    public function getClientsWithActiveOrders(): array
    {
        // TODO: Implement getClientsWithActiveOrders() method.
    }
}
