<?php declare(strict_types=1);

namespace Service\Config;

class AppConfigIniProvider implements AppConfigProviderInterface
{
    private string $configFilename;

    private array $config;

    public function __construct(string $configFilename)
    {
        $this->configFilename = $configFilename;
        $this->config = parse_ini_file($this->configFilename, true, INI_SCANNER_TYPED);
    }

    public function getAppBasePath(): string
    {
        return $this->config['app']['base_url'];
    }
}
