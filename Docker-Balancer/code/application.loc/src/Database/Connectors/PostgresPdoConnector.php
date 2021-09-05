<?php

namespace Src\Database\Connectors;

use App\Exceptions\Connection\CannotConnectPostgresException;
use PDO;
use PDOException;

class PostgresPdoConnector extends BaseSqlConnector implements IConnector
{
    public const DSN = 'pgsql';

    /**
     * Устанавливает соединение с базой данных
     *
     * @return PDO
     * @throws CannotConnectPostgresException
     */
    public function connect(): PDO
    {
        try {
            return new PDO("pgsql:host=$this->host; port=$this->port; dbname=$this->dbname;", $this->user, $this->pass);
        } catch (PDOException $pe) {
            throw new CannotConnectPostgresException($pe->getMessage(), $pe->getCode());
        }
    }
}