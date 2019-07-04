<?php

namespace Otus\Models;

use Otus\Utils\Connection;

/**
 * Class Client
 * @package Otus
 */
class BaseModel
{
    /**
     * @var
     */
    protected static $tableName;

    /**
     * Get table name
     * @return mixed
     */
    private static function getTableName()
    {
        return static::$tableName;
    }

    /**
     * Save data
     * @param string $keyColumn
     * @return BaseModel
     * @throws \Exception
     */
    public function save($keyColumn = 'id')
    {
        if ($this->{$keyColumn}) {
            return $this->update($keyColumn);
        } else {
            return $this->insert();
        }
    }

    /**
     * Update existing data
     * @param string $keyColumn
     * @return BaseModel
     * @throws \Exception
     */
    private function update($keyColumn)
    {
        $pdo = Connection::getPDO();
        $tableName = self::getTableName();
        $fields = $this->getFields();
        $values = array();
        $marks = array();
        foreach ($fields as $field) {
            if ($field != $keyColumn && $this->{$field}) {
                $values[$field] = $this->{$field};
                $marks[] = $field . ' = ?';
            }
        }
        $marks = implode(',', $marks);
        $query = $pdo->prepare("update $tableName set $marks where $keyColumn = ? RETURNING *");
        $values[] = $this->{$keyColumn};
        if (!$query->execute(array_values($values))) {
            throw new \Exception('Error: ' . $query->errorInfo()[2]);
        }
        $result = $query->fetch();
        $this->fromArray($result);
        return $this;
    }

    /**
     * Insert new data
     * @return BaseModel
     * @throws \Exception
     */
    private function insert()
    {
        $pdo = Connection::getPDO();
        $tableName = self::getTableName();
        $fields = $this->getFields();
        $values = array();
        foreach ($fields as $field) {
            if ($this->{$field}) {
                $values[$field] = $this->{$field};
            }
        }
        $marks = implode(',', array_fill(0, count($values), '?'));
        $fields = implode(',', array_keys($values));
        $query = $pdo->prepare("insert into $tableName ( $fields ) values ( $marks )  RETURNING *");
        if (!$query->execute(array_values($values))) {
            throw new \Exception('Error: ' . $query->errorInfo()[2]);
        }
        $result = $query->fetch();
        $this->fromArray($result);
        return $this;
    }

    /**
     * Delete data from db
     * @param string $keyColumn
     * @return null
     * @throws \Exception
     */
    public function delete($keyColumn = 'id')
    {
        $pdo = Connection::getPDO();
        $tableName = self::getTableName();
        $query = $pdo->prepare("delete from $tableName where $keyColumn = ?");
        if (!$query->execute([$this->{$keyColumn}])) {
            throw new \Exception('Error: ' . $query->errorInfo()[2]);
        }
        return null;
    }

    /**
     * Get fields
     * @return mixed
     */
    private function getFields()
    {
        return $this->fields;
    }

    /**
     * Apply data from array to model
     * @param $array
     * @return $this
     */
    public function fromArray($array)
    {
        foreach ($array as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }

    /**
     * Find data by id
     * @param $id
     * @param string $keyColumn
     * @return mixed|BaseModel
     * @throws \Exception
     */
    public static function findById($id, $keyColumn = 'id')
    {
        $pdo = Connection::getPDO();
        $tableName = self::getTableName();
        $record = IdentityMap::getRecord(get_called_class(), $id);
        if ($record) {
            return $record;
        }
        $query = $pdo->prepare("select * from $tableName where $keyColumn = ?");
        if (!$query->execute([$id])) {
            throw new \Exception('Error: ' . $query->errorInfo()[2]);
        }
        $result = $query->fetch();
        if (!$result) {
            return null;
        }
        $item = new static();
        $item->fromArray($result);
        IdentityMap::addRecord($item, $id);
        return $item;
    }

    /**
     * Get all data from table
     * @return array
     * @throws \Exception
     */
    public static function findAll()
    {
        $pdo = Connection::getPDO();
        $tableName = self::getTableName();
        $query = $pdo->prepare("select * from $tableName");
        if (!$query->execute()) {
            throw new \Exception('Error: ' . $query->errorInfo()[2]);
        }
        $collection = array();
        while ($result = $query->fetch()) {
            $item = new static();
            $collection[] = $item->fromArray($result);
        }
        return $collection;
    }
}