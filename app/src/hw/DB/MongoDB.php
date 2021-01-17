<?php

namespace VideoPlatform\DB;

use MongoDB\Client;
use MongoDB\Database;
use VideoPlatform\interfaces\DBInterface;

class MongoDB implements DBInterface
{
    private Client $client;

    public function __construct()
    {
        $options = ['username' => $_ENV['MONGODB_USERNAME'], 'password' => $_ENV['MONGODB_PASSWORD']];
        $this->client = new Client('mongodb://' . $_ENV['MONGODB_HOST'] . ':' . $_ENV['MONGODB_PORT'], $options);
        $this->client->selectDatabase($_ENV['MONGODB_DATABASE']);
    }

    public function save(array $data): bool
    {
        $collection = $this->client->otus->{$data['tableName']};

        $result = $collection->insertOne($data);

        if ($result) {
            echo ".";
            return true;
        }

        return  false;
    }

    public function findById($tableName, $id): array
    {
        return [];
    }

    public function query($tableName, $queryParams)
    {
        return [];
    }

    public function getAll($tableName, $limit, $offset)
    {
       return [];
    }
}
