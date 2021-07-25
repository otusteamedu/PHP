<?php


namespace Services\Connectors;


use PDO;

/**
 * Class PostgresConnector
 *
 * Подключение к базе данных Postgres
 *
 * @package Services\Connectors
 */
class PostgresConnector
{
    private string $host;
    private string $port;
    private string $dbname;
    private string $username;
    private string $password;

    /**
     * PostgresConnector constructor.
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
     * Возвращает PDO соединения с базой данных Postgres
     *
     * @return PDO
     */
    public function connect(): PDO
    {
        return new PDO("pgsql:host=$this->host; port=$this->port; dbname=$this->dbname;", $this->username, $this->password);
    }

}
