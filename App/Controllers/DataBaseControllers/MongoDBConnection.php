<?php
namespace Controllers\DataBaseControllers;

use \MongoConnectionException;
use \MongoDB\Client;
use \Config\Config;

class MongoDBConnection {
    public static $connection = null;

    public static function connectMongo()
    {
        try {
            $config = Config::config('mongo');
            self::$connection = new Client(
                $config->uri, 
                $config->uriOptions, 
                $config->DriverOptions
            );
        } catch(MongoConnectionException $e) {
            echo $e->getMessage();
        }

        return self::$connection;
    }

}