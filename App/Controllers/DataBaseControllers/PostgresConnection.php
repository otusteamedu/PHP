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
    public static function connectPostgres()
    {
        $config = Config::config('postgres');

        if (
            $conn = pg_connect("
                host={$config->host} 
                dbname={$config->dbname} 
                user={$config->user} 
                password={$config->password}
                port={$config->port}
            ")
        )
        {
            return $conn;
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