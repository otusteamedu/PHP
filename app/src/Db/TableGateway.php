<?php

namespace App\Db;

/**
 * Class TableGateway
 * @package App\Db
 */
class TableGateway
{
    private const DSN = 'pgsql:host=otus-postgres;dbname=cinema;user=cinema;password=1231';

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var bool|\PDOStatement
     */
    private $insertStmt;

    /**
     * TableGateway constructor.
     * @param string $table
     * @param array $fields
     */
    public function __construct(string $table, array $fields)
    {
        $this->pdo = new \PDO(self::DSN);

        $stmt = $this->pdo->prepare('TRUNCATE ' . $table . ' CASCADE');
        $stmt->execute();
        $stmt = $this->pdo->prepare('ALTER SEQUENCE ' . $table . '_id_seq RESTART');
        $stmt->execute();

        $this->insertStmt = $this->pdo->prepare(
            'INSERT INTO ' . $table . ' (' .
            implode(', ', $fields) . ') VALUES (:' .
            implode(', :', $fields) . ')'
        );
    }

    /**
     * @param array $fields
     * @return int
     */
    public function insert(array $fields): int
    {
        $this->insertStmt->execute($fields);

        return $this->pdo->lastInsertId();
    }
}