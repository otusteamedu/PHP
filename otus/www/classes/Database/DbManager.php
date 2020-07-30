<?php

namespace Classes\Database;

use App\AppSettings;
use Classes\Database\Drivers\DriversMap;
use Classes\Dto\DbConfigDto;
use Classes\Dto\DbDtoBuilder;

class DbManager
{
    private $config;

    public function __construct()
    {
        $this->config = include(AppSettings::CONFIG_PATH);
    }
    public function getDriver()
    {
        $connections = $this->config['connections'];
        $driver = $this->config['driver'];

        $driverClass = DriversMap::DB_DRIVERS[$driver] ?? null;

        if ($driverClass === null) {
            throw new \Exception('Нет подходящего драйвера');
        }
        /** @var Driver $driverObject*/
        $driverObject = new $driverClass();
        return $driverObject->getDriver($this->getConfigDto($connections, $driver));
    }

    private function getConfigDto (array $connections, string $driver) : DbConfigDto
    {
        $dbDtoBuilder = new DbDtoBuilder();
        $dbConfig = $connections[$driver];
        return $dbDtoBuilder
            ->setConnection($dbConfig['db_connection'])
            ->setHost($dbConfig['db_host'])
            ->setPort($dbConfig['db_port'])
            ->setDbName($dbConfig['db_database'])
            ->setUserName($dbConfig['db_username'])
            ->setDbPassword($dbConfig['db_password'])
            ->build();
    }
}
