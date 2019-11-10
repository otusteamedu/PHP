<?php

declare(strict_types=1);

namespace RowDataGateway\Gateways;

use PDO;
use PDOStatement;

abstract class AbstractGateway
{
    /**
     * @var PDO
     */
    protected $pdo;
    /**
     * @var PDOStatement
     */
    protected $insertStmt;
    /**
     * @var PDOStatement
     */
    protected $updateStmt;
    /**
     * @var PDOStatement
     */
    protected $deleteStmt;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return int
     */
    public abstract function insert(): int;

    /**
     * @return bool
     */
    public abstract function update(): bool;

    /**
     * @return bool
     */
    public abstract function delete(): bool;
}
