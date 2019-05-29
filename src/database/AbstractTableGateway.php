<?php

namespace crazydope\theater\database;

use crazydope\theater\database\adapter\PdoAdapterInterface;

abstract class AbstractTableGateway implements TableGatewayInterface
{

    /**
     * @var bool
     */
    protected $isInitialized = false;

    /**
     * @var PdoAdapterInterface
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var ResultSetInterface
     */
    protected $resultSetPrototype;

    /**
     * @return bool
     */
    public function isInitialized()
    {
        return $this->isInitialized;
    }

    /**
     * @throws \RuntimeException
     */
    public function initialize(): void
    {
        if ($this->isInitialized) {
            return;
        }

        if (! is_string($this->table)) {
            throw new \RuntimeException('This table object does not have a valid table set.');
        }

        if (! $this->resultSetPrototype instanceof ResultSetInterface) {
            $this->resultSetPrototype = new ResultSet;
        }

        $this->isInitialized = true;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param null $name
     * @return int
     */
    public function lastInsertId($name = null): int
    {
        return $this->adapter->lastInsertId($name);
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        if (empty($this->columns)) {
            $stmt = $this->adapter->prepare('SELECT * FROM ' . $this->table . ' LIMIT 0');
            $stmt->execute();
            for ($i = 0; $i < $stmt->columnCount(); $i++) {
                $col = $stmt->getColumnMeta($i);
                $this->columns[] = $col['name'];
            }
        }

        return $this->columns;
    }

    public function getResultSetPrototype(): ResultSetInterface
    {
        return $this->resultSetPrototype;
    }

    protected function whereToString($where): string
    {
        $sql = '';
        $i = 0;
        foreach ($where as $key => $value) {
            $sql .= ($i === 0) ? ' WHERE ' : ' AND ';
            $sql .= $key.' = ?';
        }
        return $sql;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool|\PDOStatement
     */
    protected function execute(string $sql, $params = [])
    {
        $stmt = $this->adapter->prepare($sql);
        $params ? $stmt->execute(array_values($params)) : $stmt->execute();
        return $stmt;
    }

    public function select($where = [])
    {
        $columns = implode(',', array_values($this->getColumns()));
        $sql = 'SELECT '.$columns.' FROM '.$this->table;
        if ($where) {
            $sql .= $this->whereToString($where);
        }
        $stmt = $this->execute($sql,$where);

        $result = $this->getResultSetPrototype();
        return $result->initialize($stmt->fetchAll());
    }

    public function insert(array $set): int
    {
        $columns = implode(',',array_keys($set));
        $sql = 'INSERT INTO '.$this->table. '('. $columns.') VALUES ('.
            implode(',', array_fill(0, count($set), '?')).')';
        $stmt = $this->execute($sql,$set);
        return $stmt->rowCount();
    }

    public function update(array $set, $where = []): int
    {
        $params = array_merge(array_values($set),array_values($where));
        
        $sql = 'UPDATE '.$this->table. ' SET ';
        
        foreach ($set as $key => $value) {
            $sql .= $key.' = ?,';
        }

        $sql = rtrim($sql,',');
        $sql .= $this->whereToString($where);

        $stmt = $this->execute($sql,$params);
        return $stmt->rowCount();
    }

    public function delete($where = []): int
    {
        $sql = 'DELETE FROM '.$this->table.$this->whereToString($where);

        $stmt = $this->execute($sql,$where);
        return $stmt->rowCount();
    }
}