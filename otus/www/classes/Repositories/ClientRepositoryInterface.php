<?php

namespace Classes\Repositories;

use Classes\Models\Client;

interface ClientRepositoryInterface
{

    public function getAllClients(): array;

    public function getClientById(int $id): Client;

    public function getClientByName(int $id): Client;

    public function getClientByAddress(int $id): Client;

    public function getClientsWithActiveOrders(): array;
}
