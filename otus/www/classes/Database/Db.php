<?php

namespace Classes\Database;

class Db
{
    private static $db;
    private $pdo;

    private function __construct()
    {
        $dbManager = new DbManager();
        try {
            $this->pdo = $dbManager->getDriver();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public static function getInstance() {

        if (!self::$db) {
            self::$db = new Db();
        }
        return self::$db;
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
