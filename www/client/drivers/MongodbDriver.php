<?php

namespace Drivers;

use \MongoDB\Client;
use \Webpatser\Uuid\Uuid;

class MongodbDriver {
    private $mongodb;
    private $collection;

    public function __construct(string $dsn, string $database, string $collection) 
    {
        $this->mongodb = (new Client($dsn, [], [
            'typeMap' => [
                'root' => 'array',
                'document' => 'array',
                'array' => 'array',
            ]
        ]))->{$database};

        $this->collection = $collection;
    }

    public function getById(string $id) : array
    {
        return $this->mongodb->{$this->collection}->findOne([
            '_id' => $id
        ]) ?? [];
    }

    public function insert(array $data) : string
    {
        return (string)$this->mongodb->{$this->collection}->insertOne(array_merge(['_id' => Uuid::generate()->string], $data))->getInsertedId();
    }
}
