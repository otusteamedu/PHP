<?php


namespace App\Database;


abstract class Model
{

    protected $table;

    protected $primaryKey = 'id';

    protected ?iConnection $connection = null;

    protected $fields = [];

    protected $relations = [];

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->fillOnCreate($data);
        }
    }

    private function fillOnCreate(array $data)
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }

    public function getKey(): string
    {
        return $this->primaryKey;
    }

    private function formatAttributeName(string $name)
    {
        return mb_strtolower(implode('_', preg_split('/(?=[A-Z])/', $name)));
    }


    public function __set($name, $value)
    {
        if (method_exists($this, $name)) {
            $this->relations[$name] = $value;
        } else {
            $this->fields[$this->formatAttributeName($name)] = $value;
        }
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            if (!array_key_exists($name, $this->relations)) {
                $this->relations[$name] = $this->$name();
            }
            return $this->relations[$name];
        }
        $name = $this->formatAttributeName($name);
        if (!array_key_exists($name, $this->fields)) {
            $this->loadField($name);
        }
        return $this->fields[$name];
    }

    private function getQuery(): Query
    {
        return new Query($this->getConnection()->pdo(), $this->table, $this->primaryKey);
    }

    public static function find(int $id, array $select = ['*']): ?Model
    {
        $static = new static;
        $result = $static->getQuery()->find($id, $select);
        if ($result) {
            $static->fillOnCreate($result);
            return $static;
        }
        return null;
    }

    public function save()
    {
        if (array_key_exists($this->primaryKey, $this->fields)) {
            $result = $this->getQuery()->update($this->fields[$this->primaryKey], array_diff_key($this->fields, [$this->primaryKey => '']));
            if ($result === false) {
                //throw Exception
            }
        } else {
            $result = $this->getQuery()->insert($this->fields);
            if ($result === false) {
                //throw Exception
            } else {
                $this->fields[$this->primaryKey] = $this->getConnection()->getLastInsertId($this->table, $this->primaryKey);
            }
        }
        return $this;
    }

    public static function findMany(array $ids, array $select = ['*'])
    {
        $collection = new ModelCollection();
        $static = new static;
        $result = $static->getQuery()->findMany($ids, $select);
        foreach ($result as $item) {
            $collection->add(new static($item));
        }
        return $collection;
    }


    public function loadField($name)
    {
        $this->$name = $this->getQuery()->find($this->id, [$name])[$name];
        return $this;
    }


    protected function getConnection()
    {
        if (!$this->connection) {
            $this->connection = Connection::getInstance();
        }
        return $this->connection;
    }

    public static function getAll()
    {

    }

    public function toArray(): array
    {
        $arr = $this->fields;
        foreach ($this->relations as $key => $attr) {
            if ($attr instanceof Model) {
                $attr = $attr->toArray();
            }
            $arr[$key] = $attr;
        }
        return $arr;
    }

}