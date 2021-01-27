<?php


namespace Otushw\Storage;

use Otushw\Exception\AppException;
use PDO;
use PDOException;

/**
 * Class DBConnection
 *
 * @package Otushw\Storage
 */
class DBConnection
{

    CONST REQUIRED_VAR = ['host', 'port', 'name', 'user_name', 'password'];

    /**
     * @var null
     */
    private static $pdo = null;

    /**
     * DBConnection constructor.
     */
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
     *
     */
    public function __destruct()
    {
        self::$pdo = null;
    }

    /**
     * @return PDO
     * @throws AppException
     */
    private function connect(): PDO
    {
        self::validateParam();

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

    /**
     * @throws AppException
     */
    private function validateParam(): void
    {
        if (empty($_ENV['DB'])) {
            throw new AppException('DB section not declared in config file');
        }

        foreach (self::REQUIRED_VAR as $item) {
            if (!isset($_ENV['DB'][$item])) {
                throw new AppException($item . ': is missing in config file');
            }
        }
    }



}