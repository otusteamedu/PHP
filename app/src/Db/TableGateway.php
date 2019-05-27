<?php

namespace App\Db;


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
        foreach ($fields as $fieldName => $fieldValue) {
            $this->insertStmt->bindParam(':' . $fieldName, $fieldValue);
        }
        $this->insertStmt->execute();

        return $this->pdo->lastInsertId();
    }
}