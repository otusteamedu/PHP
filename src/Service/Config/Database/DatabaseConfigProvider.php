<?php declare(strict_types=1);

namespace Service\Config\Database;

class DatabaseConfigProvider
{
    private string $configFilename;

    private array $databaseConfig;

    public function __construct(string $configFilename)
    {
        $this->configFilename = $configFilename;
        $this->databaseConfig = parse_ini_file($this->configFilename, true, INI_SCANNER_TYPED);
    }

    public function getPostgresDsn(): string
    {
        return $this->databaseConfig['postgres']['dsn'];
    }
}
