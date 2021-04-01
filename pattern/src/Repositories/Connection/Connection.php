<?php

namespace Src\Repositories\Connection;

class Connection
{
    public \PDO $pdo;

    private string $dbUser;

    private string $dbPassword;

    public function __construct(string $dbTable = null)
    {
        $this->dbUser = $_ENV['PDO_USER'];
        $this->dbPassword = $_ENV['PDO_PASSWORD'];
        $this->pdo = new \PDO('mysql:host=localhost;dbname=pattern', $this->dbUser, $this->dbPassword);
    }

    public function getPdoSettings(): \PDO
    {
        return $this->pdo;
    }
}