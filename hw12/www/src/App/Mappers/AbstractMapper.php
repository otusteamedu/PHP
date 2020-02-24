<?php

namespace App\Mappers;

use App\Framework\IdentityMap;

abstract class AbstractMapper
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \PDOStatement
     */
    protected $selectStmt;

    /**
     * @var \PDOStatement
     */
    protected $insertStmt;

    /**
     * @var \PDOStatement
     */
    protected $updateStmt;

    /**
     * @var \PDOStatement
     */
    protected $deleteStmt;

    /**
     * @var IdentityMap
     */
    protected $identityMap;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->identityMap = new IdentityMap();
    }

    public function __destruct()
    {
        unset($this->identityMap, $this->db);
    }
}