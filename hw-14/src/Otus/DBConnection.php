<?php

namespace Otus;


use \PDO;

class DBConnection
{
    private PDO $pdo;

    private static $instance;

    public function __construct()
    {
        $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};";
        $this->pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    }

    /**
     * @param string $statement
     * @return bool|\PDOStatement
     */
    public function prepare(string $statement)
    {
        return $this->pdo->prepare($statement);
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): DBConnection
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
