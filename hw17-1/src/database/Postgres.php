<?php

namespace TimGa\DbPatterns\Database;

class Postgres
{
    public static function connect($dns, $username, $password)
    {
        return new \PDO($dns, $username, $password);
    }
}