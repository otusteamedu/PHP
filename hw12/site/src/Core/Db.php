<?php


namespace AYakovlev\Core;


use PDO;

class Db
{
    /**
     * @var Db $instance
     */
    private static $instance;
    private PDO $pdo;

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
    // part of singleton (private constructor)
    private function __construct()
    {
        $dbOptions = (require 'settings.php')['db'];

        $this->pdo = new PDO('pgsql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']);

        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(PDO::FETCH_CLASS, $className);
    }

    // simple singleton for Db call, without clone and copy
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
