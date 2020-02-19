<?php

namespace App\Mappers;

use App\Database\DataBaseQueriesInterface;
use App\Framework\IdentityMap;
use App\Framework\IdentityMapInterface;

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
     * @var IdentityMapInterface
     */
    protected $identityMap;

    /**
     * @var DataBaseQueriesInterface
     */
    protected $queries;

    public function __construct(\PDO $pdo, DataBaseQueriesInterface $queries)
    {
        $this->pdo = $pdo;
        $this->queries = $queries;
        $this->identityMap = new IdentityMap();
    }

    public function __destruct()
    {
        unset($this->identityMap, $this->db);
    }
}