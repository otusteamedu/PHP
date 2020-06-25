<?php

namespace HomeWork\Factory;

use HomeWork\Entity\ConfigInterface;
use HomeWork\Entity\DefaultConfig;

class ConfigFactory implements ConfigFactoryInterface
{
    private array $configData;

    public function __construct(string $configFullPath)
    {
        $this->configData = parse_ini_file($configFullPath, true, INI_SCANNER_TYPED);
    }

    public function create(): ConfigInterface
    {
        return new DefaultConfig(
            $this->configData['client']['socket_address'] ?? '',
            $this->configData['server']['socket_address'] ?? '',
        );
    }
}
