<?php

namespace App;

class MySQLDatabaseConnector
{
    private $host;
    private $dbName;
    private $userName;
    private $password;
    private $connectOptions;

    public function connect(?string $host = null, ?string $dbName = null, ?string $userName = null, ?string $password = null, ?array $connectOptions = null): \PDO
    {
        $this->host = $host ?? getenv('db_host');
        $this->dbName = $dbName ?? getenv('db_name');
        $this->userName = $userName ?? getenv('db_userName');
        $this->password = $password ?? getenv('db_password');
        $this->connectOptions = $connectOptions ?? [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC];
        return new \PDO("mysql:host=$this->host;dbname=$this->dbName", $this->userName, $this->password, $this->connectOptions);
    }
}