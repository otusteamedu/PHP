<?php


namespace Repetitor202\Application\Clients\SQL\Connections;


use MongoDB\Client;

class MongoDbConnection
{
    protected static ?Client $client = null;

    final private function __construct(){}
    final private function __clone(){}
    final private function __wakeup(){}

    final private static function getClient(): ?Client
    {
        if (self::$client === null) {
            self::$client = new Client("mongodb://${_ENV['MONGODB_HOST']}:${_ENV['MONGODB_PORT']}");
        }

        return self::$client;
    }

    final private static function getDbConnection()
    {
        return self::getClient()->{$_ENV['DB_NAME']};
    }

    final public static function getTableConnection(string $table)
    {
        $dbConnection = self::getDbConnection();

        return $dbConnection->{$table};
    }
}