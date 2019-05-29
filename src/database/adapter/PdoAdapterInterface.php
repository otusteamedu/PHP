<?php

namespace crazydope\theater\database\adapter;

interface PdoAdapterInterface
{
    public function prepare($statement, $options = null);

    public function beginTransaction();

    public function commit();

    public function rollback();

    public function inTransaction();

    public function exec($statement);

    public function query($statement);

    public function lastInsertId($name = null);

    public function errorCode();

    public function errorInfo();

    public function setAttribute($attribute, $value);

    public function getAttribute($attribute);
}