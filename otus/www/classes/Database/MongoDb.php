<?php

namespace Classes\Database;

use MongoDB\Client;

class MongoDb implements Driver
{
    public function getConnection()
    {
        return new Client('mongodb://mongodb');
    }
}
