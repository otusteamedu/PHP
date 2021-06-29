<?php

declare(strict_types=1);

namespace App\Framework\Database;

use PDO;

class DbConnectionBuilder
{
    private string $driver;
    private string $host;
    private int    $port;
    private string $dbName;
    private string $userName;
    private string $password;

    public function setDriver(string $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function setDbName(string $dbName): self
    {
        $this->dbName = $dbName;

        return $this;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function build(): PDO
    {
        return new PDO($this->constructDsn(), $this->userName, $this->password);
    }

    private function constructDsn(): string
    {
        return "$this->driver:dbname=$this->dbName;host=$this->host;port=$this->port";
    }
}