<?php

namespace Otus;

use mysql_xdevapi\Exception;
use PDO;

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
     * instance of pdo
     * @var PDO
     */
    private $pdo;

    /**
     * BaseModel constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

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
     * @return BaseModel
     * @throws \Exception
     */
    public function save()
    {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    /**
     * Update existing data
     * @return BaseModel
     * @throws \Exception
     */
    private function update()
    {
        $tableName = self::getTableName();
        $fields = $this->getFields();
        $values = array();
        $marks = array();
        foreach ($fields as $field) {
            if ($field != 'id' && $this->{$field}) {
                $values[$field] = $this->{$field};
                $marks[] = $field . ' = ?';
            }
        }
        $marks = implode(',', $marks);
        $query = $this->pdo->prepare("update $tableName set $marks where id = ? RETURNING *");
        $values[] = $this->id;
        if (!$query->execute(array_values($values))) {
            throw new \Exception('Error: ' . $query->errorInfo());
        }
        $result = $query->fetch();
        return $this->fromArray($result);
    }

    /**
     * Insert new data
     * @return BaseModel
     * @throws \Exception
     */
    private function insert()
    {
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
        $query = $this->pdo->prepare("insert into $tableName ( $fields ) values ( $marks )  RETURNING *");
        if (!$query->execute(array_values($values))) {
            throw new \Exception('Error: ' . $query->errorInfo());
        }
        $result = $query->fetch();
        return $this->fromArray($result);
    }

    /**
     * Delete data from db
     * @return null
     * @throws \Exception
     */
    public function delete()
    {
        $tableName = self::getTableName();
        $query = $this->pdo->prepare("delete from $tableName where id = ?");
        if (!$query->execute([$this->id])) {
            throw new \Exception('Error: ' . $query->errorInfo());
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
     * @param PDO $pdo
     * @param int $id
     * @return mixed|BaseModel
     * @throws \Exception
     */
    public static function findById(PDO $pdo, int $id)
    {
        $tableName = self::getTableName();
        $record = IdentityMap::getRecord(get_called_class(), $id);
        if ($record) {
            return $record;
        }
        $query = $pdo->prepare("select * from $tableName where id = ?");
        if (!$query->execute([$id])) {
            throw new \Exception('Error: ' . $query->errorInfo());
        }
        $result = $query->fetch();
        $item = new static($pdo);
        $item->fromArray($result);
        IdentityMap::addRecord($item, $id);
        return $item;
    }

    /**
     * Get all data from table
     * @param PDO $pdo
     * @return array
     * @throws \Exception
     */
    public static function findAll(PDO $pdo)
    {
        $tableName = self::getTableName();
        $query = $pdo->prepare("select * from $tableName");
        if (!$query->execute()) {
            throw new \Exception('Error: ' . $query->errorInfo());
        }
        $collection = array();
        while ($result = $query->fetch()) {
            $item = new static($pdo);
            $collection[] = $item->fromArray($result);
        }
        return $collection;
    }
}