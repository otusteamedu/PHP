<?php

namespace Classes\Dto;

/**
 * @property string $dbConnection
 * @property string $host
 * @property int $port
 * @property string $dbName
 * @property string $dbUserName
 * @property string $dbPassword
 */

class DbDtoBuilder
{
    private $errors;

    private $dbConnection;
    private $host;
    private $port;
    private $dbName;
    private $dbUserName;
    private $dbPassword;

    public function setConnection(string $dbConnection)
    {
        $this->dbConnection = $dbConnection;
        return $this;
    }

    public function setHost(string $host)
    {
        $this->host = $host;
        return $this;
    }

    public function setPort (int $port)
    {
        $this->port = $port;
        return $this;
    }

    public function setDbName (string $dbName)
    {
        $this->dbName = $dbName;
        return $this;
    }

    public function setUserName (string $dbUserName)
    {
        $this->dbUserName = $dbUserName;
        return $this;
    }

    public function setDbPassword (string $dbPassword)
    {
        $this->dbPassword = $dbPassword;
        return $this;
    }


    public function build()
    {
        $this->validate();

        if (!empty($this->errors)) {
            throw new \RuntimeException(implode(';', $this->errors));
        }
        return DbConfigDto::build($this);
    }

    public function validate()
    {
        if (empty($this->dbConnection)) {
            $this->errors[] = 'Не задан тип БД';
        }

        if (empty($this->host)) {
            $this->errors[] = 'Не задано хост';
        }

        if (empty($this->port)) {
            $this->errors[] = 'Не задан порт';
        }

        if (empty($this->dbName)) {
            $this->errors[] = 'Не задано имя БД';
        }

        if (empty($this->dbUserName)) {
            $this->errors[] = 'Не задан пользователь БД';
        }

        if (empty($this->dbPassword)) {
            $this->errors[] = 'Не задан пароль БД';
        }

    }

    public function getDbConnection()
    {
        return $this->dbConnection;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getDbName()
    {
        return $this->dbName;
    }

    public function getDbUserName()
    {
        return $this->dbUserName;
    }

    public function getDbPassword()
    {
        return $this->dbPassword;
    }
}
