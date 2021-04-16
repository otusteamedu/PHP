<?php


namespace App\Database;



interface iConnection
{

    public function pdo(): \PDO;

    public static function create(array $params): iConnection;

    public function isTableExists(string $tableName): bool;

    public function getLastInsertId(string $table, string $pk);

}