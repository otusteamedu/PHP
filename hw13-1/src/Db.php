<?php

namespace TimGa\FillDb;

class Db
{
    const DB_CONF_FILE = 'db.ini';

    public static function connect()
    {
        $params = parse_ini_file(self::DB_CONF_FILE);
        if ($params === false) {
            throw new \Exception("Error reading database configuration file");
        }
        $DSN = "pgsql:
            host=" . $params['host'] . ";
            port=" . $params['port'] . ";
            dbname=" . $params['dbname'] . ";
            user=" . $params['user'] . ";
            password=" . $params['password'];
        $pdo = new \PDO($DSN);
        return $pdo;
    }
}
