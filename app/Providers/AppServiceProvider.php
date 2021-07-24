<?php


namespace app\Providers;


use Services\Connectors\PostgresConnector;
use PDO;

/**
 * Class AppServiceProvider
 * Определяет подключение к выбранной в конфигурации базе данных
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
     * @return PDO|null
     */
    public function getConnection(): ?PDO
    {
        switch ($this->connector) {
            case 'postgres':
            default :
                return (new PostgresConnector())->connect();
        }
    }
}
