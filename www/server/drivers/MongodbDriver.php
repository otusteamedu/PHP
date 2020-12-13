<?php

namespace Drivers;

use \MongoDB\Client;

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

    public function update(string $id, array $data) : object
    {
        return $this->mongodb->{$this->collection}->updateOne(
            ['_id' => $id],
            ['$set' => $data]
        );
    }
}
