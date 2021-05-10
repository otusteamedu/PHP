<?php

namespace Src\DB;

use PDO;
use PDOException;

/**
 * Class DB
 *
 * @package Src\DB
 */
class Connection
{
    private static $instance;

    private PDO $pdo;

    public static function instance(): ?PDO
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }

        return self::$instance->pdo;
    }

    public function __construct()
    {
        try {
            $dsn = "pgsql:host=" . $_ENV['POSTGRES_HOST'] .
                ";port=" . $_ENV['POSTGRES_PORT'] .
                ";user=" . $_ENV['POSTGRES_USER'] .
                ";password=" . $_ENV['POSTGRES_PASSWORD'] .
                ";dbname=" . $_ENV['POSTGRES_DB'] . ";";
            $this->pdo = new PDO($dsn);
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
