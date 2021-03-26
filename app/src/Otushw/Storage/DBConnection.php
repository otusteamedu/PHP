<?php


namespace Otushw\Storage;

use Otushw\Exception\AppException;
use PDO;
use PDOException;

class DBConnection
{

    CONST REQUIRED_VAR = ['host', 'port', 'name', 'user_name', 'password'];

    private static $pdo = null;

    private function __construct() { }

    private function __clone() { }

    private function __wakeup() { }

    public static function getInstance(): PDO
    {
        if (self::$pdo != null) {
            return self::$pdo;
        }
        self::$pdo = self::connect();
        return self::$pdo;
    }

    public function __destruct()
    {
        self::$pdo = null;
    }

    private function connect(): PDO
    {
        self::validateParam();

        $host = $_ENV['db']['host'];
        $port = $_ENV['db']['port'];
        $dbName = $_ENV['db']['name'];
        $userName = $_ENV['db']['user_name'];
        $password = $_ENV['db']['password'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbName;user=$userName;password=$password";
        try {
            $pdo = new PDO($dsn);
            if(empty($pdo)) {
                throw new AppException('DB connection is unsuccessful');
            }
            return $pdo;
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }
    }

    private function validateParam(): void
    {
        if (empty($_ENV['db'])) {
            throw new AppException('DB section not declared in config file');
        }

        foreach (self::REQUIRED_VAR as $item) {
            if (!isset($_ENV['db'][$item])) {
                throw new AppException($item . ': is missing in config file');
            }
        }
    }



}