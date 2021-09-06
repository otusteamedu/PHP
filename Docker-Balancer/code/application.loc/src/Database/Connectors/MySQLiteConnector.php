<?php

namespace Src\Database\Connectors;


use App\Exceptions\Connection\CannotConnectMySqlException;
use ErrorException;
use mysqli;
use Src\Database\Traits\HasErrorHandler;


class MySQLiteConnector extends BaseSqlConnector implements IConnector
{
    use HasErrorHandler;

    public const DSN = 'mysqlite';

    /**
     * Конструктор класса
     */
    public function __construct(string $dsn, array $config)
    {
        parent::__construct($dsn, $config);
        set_error_handler(array($this,"exception_error_handler"));
    }

    /**
     * Устанавливает соединение с базой данных
     *
     * @return mysqli
     * @throws CannotConnectMySqlException
     */
    public function connect(): mysqli
    {
        try {
            return new mysqli($this->host, $this->user, $this->pass, $this->dbname, $this->port);
        } Catch (ErrorException $ex) {
            throw new CannotConnectMySqlException($ex->getMessage(), $ex->getCode());;
        }
    }
}