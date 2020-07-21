<?php


namespace Classes\Database;


interface DbConnection
{
    public static function getConnection(Driver $driver);
}
