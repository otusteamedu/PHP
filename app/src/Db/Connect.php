<?php

namespace App\Db;

/**
 * Class Connect
 * @package App\Db
 */
class Connect
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Connect constructor.
     * @param string $dbType
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     */
    public function __construct(
        string $dbType,
        string $host,
        string $dbName,
        string $user,
        string $password
    ) {
        switch ($dbType) {
            case 'pgsql':
                $this->pdo = new \PDO("{$dbType}:host={$host};dbname={$dbName};user={$user};password={$password}");
                break;
        }
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
