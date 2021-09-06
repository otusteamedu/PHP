<?php

namespace App\Services\Checkers\Sql\Mysql;


use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
use App\Repository\Mysql\MysqlPdoReadRepository;
use PDO;
use App\Services\Checkers\AbstractChecker;
use Src\Database\Connectors\ConnectorsFactory;


class MysqlPdoChecker extends AbstractChecker
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var mixed
     */
    private mixed $driver;


    /**
     * @param array $connectionConfig
     */
    public function __construct(array $connectionConfig = [])
    {
        $this->config = $connectionConfig;
        $this->driver = $_ENV['MYSQL_DRIVER'];
    }

    /**
     * Проверка на возможность подключения к базе данных
     *
     * @return MysqlPdoChecker
     * @throws InvalidArgumentException
     */
    public function check(): self
    {
        $info = (new MysqlPdoReadRepository($this->connect()))->getInfo();
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => $this->layoutInfo($info),
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

    /**
     * Верстка Блока Info
     *
     * @param array $rows
     * @return string
     */
    private function layoutInfo(array $rows): string
    {
        $str = '';
        foreach ($rows as $row) {
            $str .= "<p>" . $row['Variable_name'] . ": " . $row['Value'] . "</p>";
        }
        return $str;
    }
}