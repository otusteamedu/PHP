<?php


namespace Services\Connectors;


use PDO;


class PostgresConnector
{

    private string $host;
    private string $dbname;
    private string $username;
    private string $password;

    /**
     * PostgresConnector constructor.
     */
    public function __construct()
    {
        $this->host     = $_ENV['DB_HOST'];
        //$this->host    .= ":" . $_ENV['DB_PORT'];
        $this->dbname   = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function connect(): ?PDO
    {
        try {
            return new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        } catch (PDOException $pe) {
            echo "Could not connect to the database $this->dbname :" . $pe->getMessage() . PHP_EOL;
            return null;
        }
    }

}
