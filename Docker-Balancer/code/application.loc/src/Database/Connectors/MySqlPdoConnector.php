<?php

namespace Src\Database\Connectors;


use App\Exceptions\Connection\CannotConnectMySqlException;
use PDO;
use PDOException;


class MySqlPdoConnector extends BaseSqlConnector implements IConnector
{
    public const DSN = 'mysql';

    /**
     * Устанавливает соединение с базой данных
     *
     * @return PDO
     * @throws CannotConnectMySqlException
     */
    public function connect(): PDO
    {
        try {
            return new PDO("mysql:host=$this->host; port=$this->port; dbname=$this->dbname;", $this->user, $this->pass);
        } catch (PDOException $pe) {
            throw new CannotConnectMySqlException($pe->getMessage(), $pe->getCode());
        }
    }
}