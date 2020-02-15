<?php declare(strict_types=1);

namespace Service\Config\Database;

class DatabaseConfigProvider
{
    private string $configFilename;

    private array $apiConfig;

    public function __construct(string $configFilename)
    {
        $this->configFilename = $configFilename;
        $this->apiConfig = parse_ini_file($this->configFilename, true, INI_SCANNER_TYPED);
    }

    public function getPostgresDsn(): string
    {
        return $this->apiConfig['postgres']['dsn'];
    }

    public function getMysqlDsn(): string
    {
        return $this->apiConfig['mysql']['dsn'];
    }
}
