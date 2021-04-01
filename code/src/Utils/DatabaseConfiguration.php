<?php


namespace App\Utils;



class DatabaseConfiguration
{
    private string $driver;
    private string $host;
    private int $port;
    private string $dbName;
    private string $username;
    private string $password;

    public function __construct(
        string $driver, string $host, int $port, string $dbName,
        string $username, string $password
    )
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): void
    {
        $this->driver = $driver;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function setDbName(string $dbName): void
    {
        $this->dbName = $dbName;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
