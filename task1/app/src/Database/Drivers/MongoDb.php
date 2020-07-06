<?php


namespace App\Database\Drivers;


use MongoDB\Client;

class MongoDb implements Driver
{
    public function getConnection($params = null)
    {
        return new Client('mongodb://mongodb');
    }
}