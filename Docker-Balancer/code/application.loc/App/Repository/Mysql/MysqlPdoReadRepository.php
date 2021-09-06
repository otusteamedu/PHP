<?php

namespace App\Repository\Mysql;

use PDO;

class MysqlPdoReadRepository
{
    /**
     * Коннектор для сервера MySql
     * @var PDO
     */
    private PDO $mysql;

    private string $query;

    public function __construct(PDO $mysql)
    {
        $this->mysql = $mysql;
        $this->query = "SHOW VARIABLES LIKE '%version%';";
    }

    public function getInfo(): array
    {
        return $this->mysql
            ->query($this->query)
            ->fetchAll();
    }
}