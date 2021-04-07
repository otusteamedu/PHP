<?php


namespace App\Database;


use PDO;

class PostgreSqlConnection implements iConnection
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    public static function create(array $params): iConnection
    {
        return new self(new PDO(
            "pgsql:host={$params['host']};port={$params['port']};dbname={$params['database']}",
            $params['user'],
            $params['password'],
            $params['options'] ?? []
        ));
    }

    public function isTableExists(string $tableName): bool
    {
        // TODO: Implement isTableExists() method.
    }

    public function getLastInsertId(string $table, string $pk)
    {
        return $this->pdo->lastInsertId("{$table}_{$pk}_seq");
    }
}