<?php

declare(strict_types=1);

namespace App\Configs;

use App\Kernel\DataBase\MongoClientCreator;
use App\Kernel\DataBase\PostgresClientCreator;
use App\Kernel\DataBase\RedisClientCreator;
use Exception;

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

        set_exception_handler('App\Exceptions\ExceptionHandler::errorHandler');
    }

    /**
     * @throws \Exception
     */
    public function createDbClient(): object
    {
        if (empty($this->config['storage'])) {
            throw new Exception('Установите хранилище данных');
        }

        switch ($this->config['storage']) {
            case 'postgres':

                return PostgresClientCreator::create($this->config);

                break;

            case 'mongodb':

                return MongoClientCreator::create($this->config);

                break;

            case 'redis':

                return RedisClientCreator::create($this->config);

                break;
        }
    }

    public function getEnvironment(): ?string
    {
        return isset($this->config['environment']) ? $this->config['environment'] : null ;
    }
}
