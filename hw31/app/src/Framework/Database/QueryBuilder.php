<?php

declare(strict_types=1);

namespace App\Framework\Database;

use Exception;
use InvalidArgumentException;
use PDO;
use PDOStatement;

class QueryBuilder
{
    private const QUERY_TYPE__SELECT = 0;
    private const QUERY_TYPE__INSERT = 1;
    private const QUERY_TYPE__UPDATE = 2;
    private const QUERY_TYPE__DELETE = 3;

    private PDO    $pdoConnection;
    private ?int   $currentQueryType;
    private string $tableName;
    private array  $select     = [];
    private array  $insertData = [];
    private array $updateData = [];
    private array $andWhere   = [];
    private array $orderBy    = [];

    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    public function select(array $fieldNames): self
    {
        $this->currentQueryType = self::QUERY_TYPE__SELECT;

        $this->select = $fieldNames;

        return $this;
    }

    public function table(string $tableName): self
    {
        $this->tableName = $tableName;

        return $this;
    }

    public function andWhere(array $params): self
    {
        $this->andWhere = $params;

        return $this;
    }

    public function orderBy(array $fieldNames): self
    {
        $this->orderBy = $fieldNames;

        return $this;
    }

    public function insert(array $data): self
    {
        $this->currentQueryType = self::QUERY_TYPE__INSERT;

        $this->insertData = $data;

        return $this;
    }

    public function update(array $data): self
    {
        $this->currentQueryType = self::QUERY_TYPE__UPDATE;

        $this->updateData = $data;

        return $this;
    }

    public function delete(): self
    {
        $this->currentQueryType = self::QUERY_TYPE__DELETE;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        switch ($this->currentQueryType) {
            case self::QUERY_TYPE__INSERT:
                $this->executeInsert();
                $this->reset();
                break;

            case self::QUERY_TYPE__UPDATE:
                $this->executeUpdate();
                $this->reset();
                break;

            case self::QUERY_TYPE__DELETE:
                $this->executeDelete();
                $this->reset();
                break;

            default:
                $this->reset();
                throw new InvalidArgumentException('Неизвестный тип запроса');
        }
    }

    /**
     * @throws Exception
     */
    public function fetch(): array
    {
        $data = $this->fetchAll();

        return ($data ? array_shift($data) : []);
    }

    /**
     * @throws Exception
     */
    public function fetchAll(): array
    {
        if ($this->currentQueryType !== self::QUERY_TYPE__SELECT) {
            throw new InvalidArgumentException('Запрос не является запросам на выборку');
        }

        $stmt = $this->executeSelect();

        $this->reset();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @throws Exception
     */
    private function executeInsert(): void
    {
        $sql = $this->constructParameterizedInsertSql();

        $this->executeSql($sql);
    }

    /**
     * @throws Exception
     */
    private function executeUpdate(): void
    {
        $sql = $this->constructParameterizedUpdateSql();

        $this->executeSql($sql);
    }

    /**
     * @throws Exception
     */
    private function executeDelete(): void
    {
        $sql = $this->constructParameterizedDeleteSql();

        $this->executeSql($sql);
    }

    /**
     * @throws Exception
     */
    private function executeSelect(): PDOStatement
    {
        $sql = $this->constructParameterizedSelectSql();

        return $this->executeSql($sql);
    }

    private function extractFieldNamesFrom(array $data): array
    {
        return array_keys($data);
    }

    private function constructParameterizedInsertSql(): string
    {
        $fieldNames = $this->extractFieldNamesFrom($this->insertData);
        $fieldCount = count($fieldNames);

        return 'INSERT INTO ' . $this->tableName . ' (' . implode(',', $fieldNames) . ') 
            VALUES (' . implode(',', array_fill(0, $fieldCount, '?')) . ');';
    }

    private function constructParameterizedUpdateSql(): string
    {
        $fieldNames = $this->extractFieldNamesFrom($this->updateData);
        $setFields = array_map(fn($fieldName) => "$fieldName = ?", $fieldNames);

        $fieldNames = $this->extractFieldNamesFrom($this->andWhere);
        $whereFields = array_map(fn($fieldName) => "$fieldName = ?", $fieldNames);

        return 'UPDATE ' . $this->tableName .
            ' SET ' . implode(',', $setFields) .
            ' WHERE ' . implode(' AND ', $whereFields) . ';';
    }

    private function constructParameterizedDeleteSql(): string
    {
        $fieldNames = $this->extractFieldNamesFrom($this->andWhere);
        $whereFields = array_map(fn($fieldName) => "$fieldName = ?", $fieldNames);

        return 'DELETE FROM ' . $this->tableName .
            ' WHERE ' . implode(' AND ', $whereFields) . ';';
    }

    private function constructParameterizedSelectSql(): string
    {
        $sql = [];
        $sql[] = 'SELECT ' . implode(',', $this->select);
        $sql[] = 'FROM ' . $this->tableName;

        if (!empty($this->andWhere)) {
            $fieldNames = $this->extractFieldNamesFrom($this->andWhere);
            $whereFields = array_map(fn($fieldName) => "$fieldName = ?", $fieldNames);

            $sql[] = 'WHERE ' . implode(' AND ', $whereFields);
        }

        if (!empty($this->orderBy)) {
            $sql[] = 'ORDER BY ' . implode(',', $this->orderBy);
        }

        return implode(' ', $sql) . ';';
    }

    /**
     * @throws Exception
     */
    private function executeSql(string $sql): PDOStatement
    {
        $stmt = $this->prepareQuery($sql);

        $this->bindValues($stmt);

        return $this->executeStatement($stmt);
    }

    /**
     * @throws Exception
     */
    private function prepareQuery(string $sql): PDOStatement
    {
        $stmt = $this->pdoConnection->prepare($sql);

        if ($stmt !== false) {
            return $stmt;
        }

        $errorMessage = $this->pdoConnection->errorInfo()[2];

        throw new Exception($errorMessage);
    }

    private function bindValues(PDOStatement $stmt): void
    {
        $index = 1;

        if ($this->currentQueryType === self::QUERY_TYPE__INSERT) {
            foreach ($this->insertData as $value) {
                $stmt->bindValue($index, $value);
                $index++;
            }
        }

        if ($this->currentQueryType === self::QUERY_TYPE__UPDATE) {
            foreach ($this->updateData as $value) {
                $stmt->bindValue($index, $value);
                $index++;
            }
        }

        foreach ($this->andWhere as $value) {
            $stmt->bindValue($index, $value);
            $index++;
        }
    }

    /**
     * @throws Exception
     */
    private function executeStatement(PDOStatement $stmt): PDOStatement
    {
        if ($stmt->execute() !== false) {
            return $stmt;
        }

        $errorMessage = $stmt->errorInfo()[2];

        throw new Exception($errorMessage);
    }

    private function reset(): void
    {
        $this->currentQueryType = null;
        $this->tableName = '';
        $this->select = [];
        $this->insertData = [];
        $this->updateData = [];
        $this->andWhere = [];
        $this->orderBy = [];
    }
}