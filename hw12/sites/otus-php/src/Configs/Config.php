<?php

declare(strict_types=1);

namespace App\Configs;

use PDO;

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
            case 'postgres':

                if (empty($this->config['postgres_user'])
                    || empty($this->config['postgres_password'])
                    || empty($this->config['postgres_db'])
                    || empty($this->config['postgres_host'])
                    || empty($this->config['postgres_port'])
                ) {
                    throw new \Exception('Установите параметры доступа к хранилищу данных');
                }

                $user = $this->config['postgres_user'];
                $pwd = $this->config['postgres_password'];
                $dbName = $this->config['postgres_db'];
                $dbHost = $this->config['postgres_host'];
                $dbPort = $this->config['postgres_port'];
                $dbh = new PDO(
                    "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}",
                    $user,
                    $pwd ,
                    [\PDO::ATTR_PERSISTENT => true]
                );

                return $dbh;

                break;
        }
    }

    public function getEnvironment(): ?string
    {
        return isset($this->config['environment']) ? $this->config['environment'] : null ;
    }
}
