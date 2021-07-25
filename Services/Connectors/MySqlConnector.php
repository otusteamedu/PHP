<?php


namespace Services\Connectors;


use PDO;

/**
 * Class MySqlConnector
 * @package Services\Connectors
 */
class MySqlConnector
{
    private string $host;
    private string $port;
    private string $dbname;
    private string $username;
    private string $password;

    /**
     * MySqlConnector constructor.
     */
    public function __construct()
    {
        $this->host     = $_ENV['DB_HOST'];
        $this->port     = $_ENV['DB_PORT'];
        $this->dbname   = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    /**
     * Возвращает PDO соединения с базой данных MySql
     *
     * @return PDO
     */
    public function connect(): PDO
    {
        return new PDO("mysql:host=$this->host; dbname=$this->dbname; port=$this->port", $this->username, $this->password);
    }

}
