<?php

namespace DB;

class Mongodb {
    private $dsn;
    private $database;
    private $collection;
    private $mongo;

    public function __construct()
    {
        $this->dsn = $this->dsn ?? $_ENV['mongodb_dsn'];
        $this->database = $this->database ?? $_ENV['mongodb_database'];
        $this->collection = $this->collection ?? $_ENV['mongodb_collection'];

        if ($this->dsn && $this->database && $this->collection) {
            $this->connect();
        } else {
            throw new Exception('no connect mongodb');
        }
    }    

    private function connect()
    {
        $this->mongo = (new MongoDB\Client($this->dsn, [], [
            'typeMap' => [
                'root' => 'array',
                'document' => 'array',
                'array' => 'array',
            ]
        ]))->{$this->database}->{$this->collection};
    } 
}
