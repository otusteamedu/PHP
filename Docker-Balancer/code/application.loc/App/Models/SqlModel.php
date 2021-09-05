<?php

namespace App\Models;


use App\Exceptions\Checkers\InvalidCheckerException;
use App\Helpers\ConfigHelper;
use App\Services\Checkers\AbstractChecker;
use App\Services\Checkers\ErrorChecker;
use App\Services\Checkers\Inspector;
use App\Services\Checkers\Sql\Mysql\MySQLiteChecker;
use App\Services\Checkers\Sql\Mysql\MysqlPdoChecker;
use App\Services\Checkers\Sql\Postgres\PostgresPdoChecker;
use App\Services\Checkers\Sql\Postgres\PostgresPgConnectChecker;
use Exception;
use JetBrains\PhpStorm\ArrayShape;


class SqlModel extends BaseModel
{
    /**
     * @return array
     */
    #[ArrayShape([
        'mysqlMasterPdo' => "array",
        'mysqlSlavePdo' => "array",
        'mysqliMaster' => "array",
        'mysqliSlave' => "array",
        'postgresPdo' => "array",
        'postgresPgConnect' => "array"
    ])]
    public function getAllSqlConnectInfo(): array
    {
        return [
            'mysqlMasterPdo'        => $this->checkMysqlPdo('mysql-master')->getInfo(),
            'mysqlSlavePdo'         => $this->checkMysqlPdo('mysql-slave')->getInfo(),
            'mysqliMaster'          => $this->checkMysqli('mysql-master')->getInfo(),
            'mysqliSlave'           => $this->checkMysqli('mysql-slave')->getInfo(),
            'postgresPdo'           => $this->checkPostgresPdo('postgres')->getInfo(),
            'postgresPgConnect'     => $this->checkPostgresPgConnect('postgres')->getInfo(),
        ];
    }

    /**
     * @param string $serverName
     * @return AbstractChecker
     */
    public function checkMysqli(string $serverName): AbstractChecker
    {
        try {
            return match ($serverName) {
                'mysql-master'   => Inspector::check(MySQLiteChecker::class, ConfigHelper::getConnectionConfigMysqlMaster()),
                'mysql-slave'    => Inspector::check(MySQLiteChecker::class, ConfigHelper::getConnectionConfigMysqlSlave()),
            };
        } catch (InvalidCheckerException $ex) {
            return new ErrorChecker($ex->getCode(), 'System Error: ' . $ex->getMessage());
        } catch (Exception $ex) {
            return new ErrorChecker($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * @param string $serverName
     * @return AbstractChecker
     */
    public function checkMysqlPdo(string $serverName): AbstractChecker
    {
        try {
            return match ($serverName) {
                'mysql-master'   => Inspector::check(MysqlPdoChecker::class, ConfigHelper::getConnectionConfigMysqlMaster()),
                'mysql-slave'    => Inspector::check(MysqlPdoChecker::class, ConfigHelper::getConnectionConfigMysqlSlave()),
            };
        } catch (InvalidCheckerException $ex) {
            return new ErrorChecker($ex->getCode(), 'System Error: ' . $ex->getMessage());
        } catch (Exception $ex) {
            return new ErrorChecker($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * @param string $serverName
     * @return AbstractChecker
     */
    public function checkPostgresPdo(string $serverName): AbstractChecker
    {
        try {
            return match ($serverName) {
                'postgres'   => Inspector::check(PostgresPdoChecker::class, ConfigHelper::getConnectionConfigPostgres()),
            };
        } catch (InvalidCheckerException $ex) {
            return new ErrorChecker($ex->getCode(), 'System Error: ' . $ex->getMessage());
        } catch (Exception $ex) {
            return new ErrorChecker($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * @param string $serverName
     * @return AbstractChecker
     */
    public function checkPostgresPgConnect(string $serverName): AbstractChecker
    {
        try {
            return match ($serverName) {
                'postgres' => Inspector::check(PostgresPgConnectChecker::class, ConfigHelper::getConnectionConfigPostgres()),
            };
        } catch (InvalidCheckerException $ex) {
            return new ErrorChecker($ex->getCode(), 'System Error: ' . $ex->getMessage());
        } catch (Exception $ex) {
            return new ErrorChecker($ex->getCode(), $ex->getMessage());
        }
    }
}