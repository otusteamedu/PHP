<?php


namespace Otushw\Storage;

use Otushw\AppException;
use PDO;
use PDOException;

class DBConnection
{
    private static $instance = null;

    private function __construct() {
        $host = $_ENV['DB']['host'];
        $port = $_ENV['DB']['port'];
        $dbName = $_ENV['DB']['name'];
        $userName = $_ENV['DB']['user_name'];
        $password = $_ENV['DB']['password'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbName;user=$userName;password=$password";
        try {
            $this->instance = new PDO($dsn);
            if(empty($this->instance)) {
                throw new AppException('DB connection is unsuccessful');
            }
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }
    }

    private function __clone() { }
    private function __wakeup() { }

    public static function getInstance()
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        return new self;
    }


}