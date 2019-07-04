<?php

namespace Otus\Utils;

use PDO;

/**
 * Class Connection
 * @package Otus\Utils
 */
class Connection
{
    /**
     * instance of class
     * @var
     */
    private static $_instance;

    /**
     * instance of pdo
     * @var PDO
     */
    private $pdo;

    /**
     * Getting instance of Connection.
     * @return Connection
     */
    static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Connection();
        }
        return self::$_instance;
    }

    /**
     * Get PDO
     * @return PDO
     */
    static function getPDO()
    {
        $inst = self::getInstance();
        if (!$inst->pdo) {
            $host = getenv('POSTGRES_HOST');
            $user = getenv('POSTGRES_USER');
            $pass = getenv('POSTGRES_PASSWORD');
            $db = getenv('POSTGRES_DB');
            $schema = getenv('POSTGRES_SCHEMA');
            $port = getenv('POSTGRES_PORT');
            $connStr = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";
            $pdo = new PDO($connStr);
            $pdo->exec("SET search_path TO $schema");
            $inst->setPDO($pdo);
        }
        return $inst->pdo;
    }

    /**
     * Set PDO
     * @param PDO $pdo
     */
    private function setPDO(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}