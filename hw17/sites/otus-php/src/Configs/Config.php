<?php

declare(strict_types=1);

namespace App\Configs;

use App\DataBase\PostgresClientCreator;
use App\DataBase\RedisClientCreator;
use App\DataBase\MongoClientCreator;
use App\Queue\NewSuperMQ\NewSuperMQCreator;
use App\Queue\QueueClientInterface;
use App\Queue\RabbitMQ\RabbitMQClientCreator;
use Exception;

class Config
{
    private const CONFIG_PATH = '/config.ini';

    private $config;

    public function __construct(string $configPath = null)
    {
        self::setExceptionHandler();

        $configPath = $configPath ?: $_SERVER['PWD'] . self::CONFIG_PATH;
        $this->config = parse_ini_file($configPath);

        if ($this->config['environment'] == 'dev'
            && $this->config['debug'] == true
        ) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'on');
        } else {
            ini_set('display_errors', 'off');
        }
    }

    /**
     * @throws \Exception
     */
    public function createDbClient(): object
    {
        if (empty($this->config['storage'])) {
            throw new Exception('Установите хранилище данных');
        }

        try {
            switch ($this->config['storage']) {
                case 'postgres':

                    return PostgresClientCreator::create($this->config);

                    break;

                case 'redis':

                    return RedisClientCreator::create($this->config);

                    break;
            }

            throw new \Exception('Установите используемое хранилище данных в файле конфигурации "config.ini"');
        } catch (\Throwable $e) {
            // TODO сделать логирование ошибок
            $erMsg = "{$e->getMessage()}, {$e->getFile()}, {$e->getLine()}";

            throw new \Exception($erMsg);
        }
    }

    /**
     * @throws \Exception
     */
    public function createQueueClient(): QueueClientInterface
    {
        if (empty($this->config['queue_broker'])) {
            throw new Exception('Установите брокера сообщений');
        }

        try {
            switch ($this->config['queue_broker']) {
            case 'rabbitmq':

                return RabbitMQClientCreator::create($this->config);

                break;

            case 'new_super_mq':

                return NewSuperMQCreator::create($this->config);

                break;
            }

            throw new \Exception('Установите используемый брокер сообщений в файле конфигурации "config.ini"');
        } catch (\Throwable $e) {
            // TODO сделать логирование ошибок
            $erMsg = "{$e->getMessage()}, {$e->getFile()}, {$e->getLine()}";

            throw new \Exception($erMsg);
        }
    }

    public function getEnvironment(): ?string
    {
        return isset($this->config['environment']) ? $this->config['environment'] : null ;
    }

    public function getParameter(string $name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : null ;
    }

    public static function setExceptionHandler()
    {
        set_exception_handler('App\Exceptions\ExceptionHandler::errorHandler');
    }
}
