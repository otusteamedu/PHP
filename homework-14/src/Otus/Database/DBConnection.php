<?php

namespace Otus\Database;

use Otus\Config\ConfigContract;
use PDO;

abstract class DBConnection
{
    protected PDO $pdo;

    public function __construct(ConfigContract $config)
    {
        $this->pdo = $this->createPdo($config);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    abstract protected function createPdo(ConfigContract $config): PDO;
}
