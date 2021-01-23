<?php


namespace Otushw\Storage;

use Otushw\AppException;
use PDO;
use PDOException;

class DBConnection
{
    private static $pdo = null;

    private function __construct() { }
    private function __clone() { }
    private function __wakeup() { }

    /**
     * @return PDO
     * @throws AppException
     */
    public static function getInstance(): PDO
    {
        if (self::$pdo != null) {
            return self::$pdo;
        }
        self::$pdo = self::connect();
        return self::$pdo;
    }

    /**
     * @return PDO
     * @throws AppException
     */
    private function connect(): PDO
    {
        $host = $_ENV['DB']['host'];
        $port = $_ENV['DB']['port'];
        $dbName = $_ENV['DB']['name'];
        $userName = $_ENV['DB']['user_name'];
        $password = $_ENV['DB']['password'];

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



}