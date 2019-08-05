<?php

namespace App;

class Db
{
    protected $dbh;
    protected static $connection;

    protected function __construct()
    {
        $config = new Config();
        $conf = $config->getData();
        $driver = $conf['db']['driver'];
        $host = $conf['db']['host'];
        $dbname = $conf['db']['dbname'];
        $dsn = $driver . ':host=' . $host . ';dbname=' . $dbname;
        try {
            $this->dbh = new \PDO($dsn, 'postgres', '321', [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',]);
        } catch (\PDOException $exception) {

            $exception->getMessage();

        }
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    public static function getInstance()
    {
        if (static::$connection === null) {
            static::$connection = new static();
        }
        return static::$connection;
    }

    public function execute(string $sql, array $data = [])
    {
        $sth = $this->dbh->prepare($sql);
        $result = $sth->execute($data);
        if (false === $result) {
            var_dump($sth->errorInfo());
            die;
        }
        return true;
    }

    public function query(string $sql, array $data = [], $class = null)
    {
        $sth = $this->dbh->prepare($sql);
        $result = $sth->execute($data);
        if (false === $result) {
            var_dump($sth->errorInfo());
            die;
        }
        if (null === $class) {
            return $sth->fetchAll();
        } else {
            return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
        }
    }

    public function queryEach(string $sql, array $data = [], $class = null)
    {
        $sth = $this->dbh->prepare($sql);
        $result = $sth->execute($data);
        if (false === $result) {
            var_dump($sth->errorInfo());
            die;
        }
        if (null === $class) {
            while ($row = $sth->fetch()) {
                yield $row;
            }
        } else {
            $sth->setFetchMode(\PDO::FETCH_CLASS, $class);
            while ($row = $sth->fetch()) {
                yield $row;
            }
        }
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

}