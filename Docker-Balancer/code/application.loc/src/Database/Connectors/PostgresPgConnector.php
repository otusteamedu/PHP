<?php

namespace Src\Database\Connectors;


use App\Exceptions\Connection\CannotConnectPostgresException;
use Src\Database\Traits\HasErrorHandler;
use ErrorException;


class PostgresPgConnector extends BaseSqlConnector implements IConnector
{
    use HasErrorHandler;

    public const DSN = 'pg_connect';

    /**
     * Конструктор класса
     */
    public function __construct(string $dsn, array $config)
    {
        parent::__construct($dsn, $config);
        set_error_handler(array($this,"exception_error_handler"));
    }

    /**
     * @return mixed
     * @throws CannotConnectPostgresException
     */
    public function connect(): mixed
    {
        $conn_string = "host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->pass";
        try {
            return pg_connect($conn_string);
        } Catch (ErrorException $ex) {
            throw new CannotConnectPostgresException($ex->getMessage(), $ex->getCode());;
        }
    }
}