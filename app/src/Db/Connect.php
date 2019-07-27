<?php

namespace App\Db;

use App\Config;
use PDO;

/**
 * Class Connect
 * @package App
 */
class Connect
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Connect constructor.
     * @param Config $config
     */
    public function __construct(Config $config) {
        switch ($config::DB_TYPE) {
            case 'pgsql':
                $this->pdo = new PDO($config::DB_TYPE . ':host=' . $config::DB_HOST .
                    ';dbname=' . $config::DB_NAME .
                    ';user=' . $config::DB_USER .
                    ';password=' . $config::DB_PASS
                );
                break;
        }
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
