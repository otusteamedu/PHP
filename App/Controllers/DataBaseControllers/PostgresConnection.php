<?php
namespace Controllers\DataBaseControllers;


use \Config\Config;
use \Exception;

class PostgresConnection {

    public $postgres = null;
    private $config;
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $port;

    public function __construct()
    {
        $this->config = Config::config('postgres');
        $this->host = $this->config->host;
        $this->dbname = $this->config->dbname;
        $this->password = $this->config->dbpassword;
        $this->user = $this->config->dbuser;
        $this->port = $this->config->port;
    }

    /**
     * функция соединения с Postgres
     * @return false|resource
     */
    public function connectPostgres()
    {
        if (
            $conn = pg_connect("
                host={$this->host} 
                dbname={$this->dbname} 
                user={$this->user} 
                password={$this->password}
                port={$this->port}
            ")
        )
        {
            return $this->postgres = $conn;
        } else {
            throw new Exception('Хост или пароль указаны неверно');
        }
    }

    /**
     * Функция генерации строки конфигурации для подключения к PostgreSQL
     * @return string
     */
    public function connectionString(): string
    {
        return sprintf(
            "pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s",
            $this->host,
            $this->port,
            $this->dbname,
            $this->user,
            $this->password
        );

    }
}