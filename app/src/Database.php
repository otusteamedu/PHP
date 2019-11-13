<?php

namespace App;

class Database
{
    private $host = 'mysql';
    private $dbName = 'hw';
    private $userName = 'root';
    private $password = 'root';
    private $connectOptions = [
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ];

    public function connect(): \PDO
    {
        return new \PDO("mysql:host=$this->host;dbname=$this->dbName", $this->userName, $this->password, $this->connectOptions);
    }
}