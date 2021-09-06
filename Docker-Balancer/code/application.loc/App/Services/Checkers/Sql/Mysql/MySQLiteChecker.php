<?php

namespace App\Services\Checkers\Sql\Mysql;


use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
use App\Repository\Mysql\MysqliReadRepository;
use App\Services\Checkers\AbstractChecker;
use Src\Database\Connectors\ConnectorsFactory;


class MySQLiteChecker extends AbstractChecker
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
        $this->driver = $_ENV['MYSQLITE_DRIVER'];
    }

    /**
     * Проверка на возможность подключения к базе данных
     *
     * @return MySQLiteChecker
     * @throws InvalidArgumentException
     */
    public function check(): MySQLiteChecker
    {
        [$hostInfo, $protocolVersion, $rows] = ((new MysqliReadRepository($this->connect()))->getInfo());
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => "<p>Server info:</p>"
                            . "<p>Host: $hostInfo</p>"
                            . "<p>Protocol version: $protocolVersion</p>"
                            . "<p>&nbsp;</p>"
                            . "<p>Client info:</p>"
                            . $this->layoutInfo($rows)
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
            // строки приходят в виде объектов
            foreach (get_object_vars($row) as $property => $value) {
                $str .= "<p>" . $property . ": " . $value . "</p>";
            }
        }
        return $str;
    }
}