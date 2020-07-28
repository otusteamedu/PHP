<?php

namespace Classes\Database\Drivers;

use Classes\Database\Driver;
use Classes\Dto\DbConfigDto;
use PDO;

class PostgresPdoDriver implements Driver
{
    /**
     * @param DbConfigDto $dbConfigDto
     * @return PDO
     */
    public function getDriver(DbConfigDto $dbConfigDto): PDO
    {
        $dsn = "pgsql:host=$dbConfigDto->host;port=$dbConfigDto->port;dbname=$dbConfigDto->dbName";
        $pdo = new PDO($dsn, $dbConfigDto->dbUserName, $dbConfigDto->dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return  $pdo;
    }
}
