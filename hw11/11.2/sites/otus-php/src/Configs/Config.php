<?php

declare(strict_types=1);

namespace App\Configs;

use MongoDB;
use Predis;

class Config
{
    private $config;

    public function __construct(string $configPath = null)
    {
        $configPath = $configPath ?: $_SERVER['DOCUMENT_ROOT'] . '/config.ini';
        $this->config = parse_ini_file($configPath);

        if ($this->config['environment'] == 'dev') {
            error_reporting(E_ALL);
            ini_set('display_errors', 'on');
        }
    }

    public function createDbClient(): object
    {
        if (empty($this->config['storage'])) {
            throw new \Exception('Установите хранилище данных');
        }

        switch ($this->config['storage']) {
            case 'mongodb':

                if (empty($this->config['mongo_db_user'])
                    || empty($this->config['mongo_db_password'])
                    || empty($this->config['mongo_db'])
                ) {
                    throw new \Exception('Установите параметры доступа к хранилищу данных');
                }

                $user = $this->config['mongo_db_user'];
                $pwd = $this->config['mongo_db_password'];
                $dbName = $this->config['mongo_db'];
                $mongoClient = new MongoDB\Client("mongodb://{$user}:{$pwd}@mongodb:27017");

                return $mongoClient->$dbName;

                break;

            case 'redis':

                return new Predis\Client('tcp://redis:6379');

                break;
        }
    }

}
