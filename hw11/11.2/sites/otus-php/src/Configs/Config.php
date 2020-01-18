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
        } else {
            ini_set('display_errors', 'off');
        }

        set_exception_handler('App\Kernel\ExceptionHandler::errorHandler');
    }

    /**
     * @throws \Exception
     */
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
                    || empty($this->config['mongo_db_port'])
                ) {
                    throw new \Exception('Установите параметры доступа к хранилищу данных');
                }

                $user = $this->config['mongo_db_user'];
                $pwd = $this->config['mongo_db_password'];
                $dbName = $this->config['mongo_db'];
                $dbPort = $this->config['mongo_db_port'];
                $mongoClient = new MongoDB\Client("mongodb://{$user}:{$pwd}@mongodb:{$dbPort}");

                return $mongoClient->$dbName;

                break;

            case 'redis':

                if (empty($this->config['redis_port'])) {
                    throw new \Exception('Установите параметры доступа к хранилищу данных');
                }

                $dbPort = $this->config['redis_port'];

                return new Predis\Client("tcp://redis:{$dbPort}");

                break;
        }
    }

    public function getEnvironment(): ?string
    {
        return isset($this->config['environment']) ? $this->config['environment'] : null ;
    }
}
