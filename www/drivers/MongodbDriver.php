<?php

namespace Drivers;

use MongoDB\Client;
use MongoDB\BSON\ObjectID;

class MongodbDriver {
    private $mongodb;

    public function __construct(string $dsn, string $database) : void
    {
        $this->mongodb = (new Client($dsn, [], [
            'typeMap' => [
                'root' => 'array',
                'document' => 'array',
                'array' => 'array',
            ]
        ]))->{$database};
    }

    public function getById(string $collection, string $id) : array
    {
        return $this->mongodb->{$collection}->findOne([
            '_id' => new ObjectID($id)
        ]);
    }

    public function insert(string $collection, array $data) : string
    {
        return (string)$this->mongodb->{$collection}->insertOne($data)->getInsertedId();
    }

    public function update(string $collection, string $id, array $data) : object
    {
        return $this->mongodb->{$collection}->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
    }
}
