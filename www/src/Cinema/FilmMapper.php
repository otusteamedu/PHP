<?php

namespace Tirei01\Hw12\Cinema;

use Tirei01\Hw12\Mapper;
use Tirei01\Hw12\DomainObject;

class FilmMapper extends Mapper
{

    private $selectStmt;
    private $updateStmt;
    private $insertStmt;

    public function __construct(\PDO $dbh)
    {
        //$dsn = 'mysql:dbname=sitemanager;host=localhost';
        //$user = 'bitrix0';
        //$password = 'v-c+xT4Nu@2l!}ryE1}&';
        //$servername = "localhost";
        //$dsn = 'mysql:dbname=sitemanager;unix_socket=/var/lib/mysqld/mysqld.sock';
        //$dbh = new \PDO($dsn, $user, $password);
        //$dbh = new PDO("mysql:host=$servername;port=3306;dbname=sitemanager;charset=utf8", $user, $password);
        parent::__construct($dbh);
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM b_user WHERE ID=?");
        $this->updateStmt = $this->pdo->prepare("UPDATE b_user SET NAME=?, ID=? WHERE ID=?");
        $this->insertStmt = $this->pdo->prepare("INSERT INTO b_user (NAME) VALUES ( ? )");
    }

    public function update(DomainObject $object)
    {
        $values = array($object->getName(), $object->getId(), $object->getId());
        $this->updateStmt->execute($values);
    }

    protected function doCreateObject(array $raw): DomainObject
    {
        return new Film($raw['ID'], $raw['NAME']);
    }

    protected function doInsert(DomainObject $object)
    {
        $value = array($object->getName());
        $this->insertStmt->execute($value);
        $id = $this->pdo->lastInsertId();
        $object->setId($id);
    }

    protected function selectStmt(): \PDOStatement
    {
        return $this->selectStmt;
    }

    protected function targetClass(): string
    {
        return static::class;
    }
}