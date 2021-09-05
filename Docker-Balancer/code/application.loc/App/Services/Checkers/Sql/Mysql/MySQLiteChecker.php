<?php

namespace App\Services\Checkers\Sql\Mysql;


use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
use App\Services\Checkers\AbstractChecker;
use mysqli_result;
use Src\Database\Connectors\ConnectorsFactory;


class MySQLiteChecker extends AbstractChecker
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
     * @var mixed
     */
    private mixed $driver;


    /**
     * Конструктор класса
     *
     * @param array $connectionConfig
     */
    public function __construct(array $connectionConfig = [])
    {
        $this->config = $connectionConfig;
        $this->driver = $_ENV['MYSQLITE_DRIVER'];
        $this->query = "SELECT SUBSTRING_INDEX(USER(), '@', -1) AS ip,  @@hostname as hostname, @@port as port, DATABASE() as current_database;";
    }

    /**
     * Проверка на возможность подключения к базе данных
     *
     * @return MySQLiteChecker
     * @throws InvalidArgumentException
     */
    public function check(): MySQLiteChecker
    {
        $mysqli  = $this->connect();
        $result = $mysqli->query($this->query);
        $rows = $result ? $this->fetchAll($result) : [];
        $hostInfo = $mysqli->host_info;
        $protocolVersion = $mysqli->protocol_version;
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => "<p>Server info:</p>"
                            . "<p>Host: $hostInfo</p>"
                            . "<p>Protocol version: $protocolVersion</p>"
                            . "<p>&nbsp;</p>"
                            . "<p>Client info:</p>"
                            . $this->layoutInfo($rows)
        ];
        $mysqli->close();
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

    /**
     * Преобразование данных запроса в массив
     *
     * @param mysqli_result $result
     * @return array
     */
    private function fetchAll(mysqli_result $result): array
    {
        $fetchedRows = [];
        while ($row = $result->fetch_object()){
            $fetchedRows[] = $row;
        }
        return $fetchedRows;
    }
}