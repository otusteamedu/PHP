<?php


namespace app\Providers;


use Services\Connectors\MySqlConnector;
use Services\Connectors\PostgresConnector;
use PDO;

/**
 * Class AppServiceProvider
 *
 * Определяет подключение к выбранной в конфигурации базе данных
 *
 * @package app\Providers
 */
class AppServiceProvider
{
    private mixed $connector;
    /**
     * AppServiceProvider constructor.
     */
    public function __construct()
    {
        $this->connector = $_ENV['DB_CONNECTION'];
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        switch ($this->connector) {
            case 'mysql':
                return (new MySqlConnector())->connect();
            case 'postgres':
            default :
                return (new PostgresConnector())->connect();
        }
    }
}
