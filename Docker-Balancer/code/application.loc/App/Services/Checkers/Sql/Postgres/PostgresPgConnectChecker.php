<?php

namespace App\Services\Checkers\Sql\Postgres;


use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
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
     * Конструктор класса
     *
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
        $conn = $this->connect();
        $result = pg_query($conn, $this->query);
        $row = pg_fetch_row($result);
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => "Database: ".$row[0],
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