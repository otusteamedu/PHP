<?php

namespace App\Services\Checkers\Sql\Postgres;


use App\Helpers\AppConst;
use PDO;
use App\Exceptions\Connection\InvalidArgumentException;
use App\Services\Checkers\AbstractChecker;
use Src\Database\Connectors\ConnectorsFactory;


class PostgresPdoChecker extends AbstractChecker
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
        $this->driver = $_ENV['PGSQL_DRIVER'];
        $this->query = "SELECT version();";
    }

    /**
     * Проверка на возможность подключения к базе данных
     *
     * @return PostgresPdoChecker
     * @throws InvalidArgumentException
     */
    public function check(): self
    {
        $row = $this
            ->connect()
            ->query($this->query)
            ->fetch();
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => $row[0],
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