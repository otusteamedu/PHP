<?php

namespace Classes\Models;

use Classes\Database\Db;

abstract class AbstractActiveRecord
{
    protected static $tableName;

    public function save()
    {
        $pdo = Db::getInstance()->getPDO();

        if ($this->id) {
            $sth = $pdo->prepare(
                'UPDATE ' . static::$tableName .
                ' SET ' . $this->prepareUpdate() .
                ' WHERE ID = :id'
            );

            $sth->bindParam(':id', $this->id, \PDO::PARAM_INT);

        } else {

            $sth = $pdo->prepare(
                'INSERT INTO ' . static::$tableName . '(' .  $this->getInsertKeys() . ') VALUES (' . $this->getInsertValues() . ')'
            );
        }

        $vars = $this->getVars();

        if (array_key_exists('id', $vars)) {
            unset($vars['id']);
        }

        foreach ($vars as $key => $var) {
            $sth->bindValue(':' . $key, $var);
        }

        $sth->execute();
    }

    protected function getVars()
    {
        $vars = get_object_vars($this);

        if (isset($vars['id'])) {
            unset($vars['id']);
        }
        return $vars;
    }

    private function getInsertKeys ()
    {
        $vars = $this->getVars();
        if (array_key_exists('id', $vars)) {
            unset($vars['id']);
        }
        $varsKeys = array_keys($vars);
        return implode(',', $varsKeys);
    }

    private function getInsertValues ()
    {
        $vars = $this->getVars();
        if (array_key_exists('id', $vars)) {
            unset($vars['id']);
        }
        $varsKeys = array_keys($vars);
        $arSql = [];

        foreach ($varsKeys as $key) {
            $arSql[] = ':' . $key;
        }
        return implode(',', $arSql);
    }

    protected function prepareUpdate()
    {
        $vars = $this->getVars();
        $varsKeys = array_keys($vars);

        $arSql = [];

        foreach ($varsKeys as $key) {
            $arSql[] = $key . '=:' . $key;
        }
        return implode(',', $arSql);
    }

    public static function delete($id)
    {
        $pdo = Db::getInstance()->getPDO();

        $sth = $pdo->prepare(
            'DELETE FROM  ' . static::$tableName .
            ' WHERE id = :id'
        );

        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
    }

    public static function find($id)
    {
        $pdo = Db::getInstance()->getPDO();
        $sth = $pdo->prepare('SELECT * FROM ' . static::$tableName . ' WHERE ID = ?');
        $sth->execute([$id]);
        return ($sth->fetchObject(get_called_class()));
    }
}
