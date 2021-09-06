<?php

namespace App\Services\Checkers\Sql\Postgres;


use App\Helpers\AppConst;
use App\Repository\Postgres\PostgresPdoReadRepository;
use PDO;
use App\Exceptions\Connection\InvalidArgumentException;
use App\Services\Checkers\AbstractChecker;
use Src\Database\Connectors\ConnectorsFactory;


class PostgresPdoChecker extends AbstractChecker
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var string
     */
    private string $driver;


    /**
     * @param array $connectionConfig
     */
    public function __construct(array $connectionConfig = [])
    {
        $this->config = $connectionConfig;
        $this->driver = $_ENV['PGSQL_DRIVER'];
    }

    /**
     * Проверка на возможность подключения к базе данных
     *
     * @return PostgresPdoChecker
     * @throws InvalidArgumentException
     */
    public function check(): self
    {
        $info = (new PostgresPdoReadRepository($this->connect()))->getInfo();
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => $info['version'],
        ];
        return $this;
    }

    /**
     * Устанавливает соединение с базой данных
     *
     * @return PDO
     * @throws InvalidArgumentException
     */
    private function connect(): PDO
    {
        return ConnectorsFactory::createConnection($this->driver, $this->config)->connect();
    }
}