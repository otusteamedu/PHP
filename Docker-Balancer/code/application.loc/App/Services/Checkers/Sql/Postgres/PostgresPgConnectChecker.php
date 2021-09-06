<?php

namespace App\Services\Checkers\Sql\Postgres;


use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
use App\Repository\Postgres\PostgresPgConnectReadRepository;
use App\Services\Checkers\AbstractChecker;
use Src\Database\Connectors\ConnectorsFactory;


class PostgresPgConnectChecker extends AbstractChecker
{
    /**
     * @var string
     */
    private string $query;

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
        $this->driver = $_ENV['PGSQL_PG_DRIVER'];
        $this->query = "SELECT version();";
    }

    /**
     * Проверка на возможность подключения к базе данных
     *
     * @return PostgresPgConnectChecker
     * @throws InvalidArgumentException
     */
    public function check(): self
    {
        $info = (new PostgresPgConnectReadRepository($this->connect()))->getInfo();
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => "Database: ".$info[0],
        ];
        return $this;
    }

    /**
     * Устанавливает соединение с базой данных
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    private function connect(): mixed
    {
        return ConnectorsFactory::createConnection($this->driver, $this->config)->connect();
    }
}