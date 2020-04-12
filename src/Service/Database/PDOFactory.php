<?php declare(strict_types=1);

namespace Service\Database;

use Service\Config\Database\DatabaseConfigProvider;

class PDOFactory
{
    private DatabaseConfigProvider $configProvider;

    public function __construct()
    {
        $this->configProvider = new DatabaseConfigProvider(__DIR__ . '/../../../config/config.ini');
    }

    public function getPostgresPDO(): \PDO
    {
        return new \PDO($this->configProvider->getPostgresDsn());
    }
}
