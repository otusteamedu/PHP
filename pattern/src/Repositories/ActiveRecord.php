<?php


namespace Src\Repositories;

use PDO;

class ActiveRecord implements ActiveRecordInterface
{
    public PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function getAll(PDO $PDO) : array
    {
        // TODO: Implement getAll() method.
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
    }
}