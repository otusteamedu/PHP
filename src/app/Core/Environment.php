<?php

namespace App\Core;

class Environment
{
    public const APP_ENV_DEVELOPMENT = 'development';
    public const APP_ENV_PRODUCTION = 'production';

    private string $profile = self::APP_ENV_PRODUCTION;
    private string $link = '';

    /**
     * AppEnvironment constructor.
     * @param array|null $env
     */
    public function __construct(?array $env = null)
    {
        $this->profile = $env['APPLICATION_ENV'] ??
                         $_ENV['APPLICATION_ENV'] ?: self::APP_ENV_PRODUCTION;
        $this->link = $env['db_link'] ?? $_ENV['db_link'] ?: '';
    }

    /**
     * @return bool
     */
    public function isProduction(): bool
    {
        return $this->profile === self::APP_ENV_PRODUCTION;
    }

    /**
     * @return string
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * @return DbLink
     */
    public function getPdoConnector(): DbLink
    {
        return new DbLink($this->link);
    }
}