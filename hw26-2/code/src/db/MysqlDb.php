<?php

namespace TimGa\hw26\db;

class MysqlDb
{

    public function connect(): \PDO
    {
        $host = '192.168.56.101';
        $db = 'otus';
        $user = 'timofey';
        $pass = 'timofey123';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new \PDO($dsn, $user, $pass, $opt);
    }

}
