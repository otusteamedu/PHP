<?php
/**
 * @var \App\Db $db ;
 */

namespace App;

use App\Identity;

abstract class Model
{
    public static $table;
    public $id;


    public static function findAll()
    {
        $db = Db::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::$table,
            [],
            static::class
        );
        return $data;
    }

    public static function findById($id)
    {
        $obj = Identity::getRecord($id);
        if ($obj != null) {
            return $obj;
        }

        $db = Db::getInstance();
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE id=:id';
        $data = $db->query($sql, [':id' => $id], static::class);
        Identity::addRecord($data[0], $id);
        return $data[0] ?? false;
    }

    public static function deleteById(int $id)
    {
        $db = Db::getInstance();
        $sql = 'DELETE FROM ' . static::$table . ' WHERE id=:id';
        $db->execute($sql, [':id' => $id]);
    }

    public function isNew()
    {
        return empty($this->id);
    }

    protected function insert()
    {
        $columns = [];
        $binds = [];
        $data = [];
        foreach ($this as $column => $value) {
            if ('id' == $column) {
                continue;
            }
            $columns[] = $column;
            $binds[] = ':' . $column;
            $data[':' . $column] = $value;
        }
        $sql = '
                INSERT INTO ' . static::$table . '
                (' . implode(', ', $columns) . ')
                VALUES
                (' . implode(', ', $binds) . ')
                ';
        $db = Db::getInstance();
        $db->execute($sql, $data);
        $this->id = $db->lastInsertId();
    }

    protected function update()
    {
        $columns = [];
        $data = [];
        $sql = 'UPDATE ' . static::$table . ' SET ';
        foreach ($this as $column => $value) {
            $data[':' . $column] = $value;
            if ('id' == $column) {
                continue;
            }
            $columns[] = $column . ' = :' . $column;
        }
        $sql = $sql . implode(', ', $columns) . ' WHERE id= ' . ':id';
        $db = Db::getInstance();
        $db->execute($sql, $data);
    }

    public function save()
    {
        if ($this->isNew()) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    public function delete()
    {
        $sql = 'DELETE FROM ' . static::$table . ' WHERE id= ' . $this->id;
        $db = Db::getInstance();
        $db->execute($sql);
    }
}