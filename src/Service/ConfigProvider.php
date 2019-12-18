<?php

declare(strict_types=1);

namespace Service;

class ConfigProvider
{
    private string $configFilename;

    /**
     * ConfigProvider constructor.
     * @param string $configFilename
     */
    public function __construct(string $configFilename)
    {
        $this->configFilename = $configFilename;
    }

    public function getClientSocketAddress(): string
    {
        $socketConfig = parse_ini_file($this->configFilename, true, INI_SCANNER_TYPED);

        return $socketConfig['client']['address'];
    }

    public function getServerSocketAddress(): string
    {
        $socketConfig = parse_ini_file($this->configFilename, true, INI_SCANNER_TYPED);

        return $socketConfig['server']['address'];
    }
}