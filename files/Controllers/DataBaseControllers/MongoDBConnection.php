<?php
namespace Controllers\DataBaseControllers;

use \MongoConnectionException;
use \MongoDB\Client;

class MongoDBConnection {
    public static $connection = null;

    public static function connectMongo()
    {
        try {
            self::$connection = new Client("mongodb://172.22.0.1");
        } catch(MongoConnectionException $e) {
            echo $e->getMessage();
        }

        return self::$connection;
    }

}