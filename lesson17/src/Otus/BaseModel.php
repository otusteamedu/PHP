<?php

namespace Otus;
use mysql_xdevapi\Exception;

/**
 * Class Client
 * @package Otus
 */
class BaseModel
{
    protected $tableName;
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function getTableName()
    {
        return $this->tableName;
    }

    public function save()
    {

        if ($this->id) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    private function update()
    {
        $tableName = $this->getTableName();
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

    private function insert()
    {
        $tableName = $this->getTableName();
        $fields = $this->getFields();
        $values = array();
        foreach ($fields as $field) {
            if ( $this->{$field}) {
                $values[$field] = $this->{$field};
            }
        }
        $marks = implode(',',array_fill(0,count($values),'?'));
        $fields = implode(',', array_keys($values));
        $query = $this->pdo->prepare("insert into $tableName ( $fields ) values ( $marks )  RETURNING *");
        if (!$query->execute(array_values($values))) {
            throw new \Exception('Error: ' . $query->errorInfo());
        }
        $result = $query->fetch();
        return $this->fromArray($result);
    }

    public function delete()
    {
        $tableName = $this->getTableName();
        $query = $this->pdo->prepare("delete from $tableName where id = ?");
        $query->execute([$this->id]);
        return null;
    }

    private function getFields()
    {
        return $this->fields;
    }

    public function fromArray($array)
    {
        foreach ($array as $key => $value) {
            if (isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }
}