<?php

namespace App\Repository\Mysql;


use mysqli;
use mysqli_result;

class MysqliReadRepository
{
    /**
     * Коннектор для сервера MySql
     * @var mysqli
     */
    private mysqli $mysqli;

    private string $query;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
        $this->query = "SELECT SUBSTRING_INDEX(USER(), '@', -1) AS ip,  @@hostname as hostname, @@port as port, DATABASE() as current_database;";
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        $result = $this->mysqli->query($this->query);
        $rows = $result ? $this->fetchAll($result) : [];
        $hostInfo = $this->mysqli->host_info;
        $protocolVersion = $this->mysqli->protocol_version;
        $this->mysqli->close();
        return [$hostInfo, $protocolVersion, $rows];
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