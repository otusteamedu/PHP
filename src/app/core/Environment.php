<?php

namespace Core;

class Environment
{
    public const APP_ENV_DEVELOPMENT = 'development';
    public const APP_ENV_PRODUCTION = 'production';

    private string $profile = self::APP_ENV_PRODUCTION;
    private string $dbDsn = '';

    /**
     * AppEnvironment constructor.
     * @param array|null $env
     */
    public function __construct(?array $env = null)
    {
        $this->profile = $env['APP_ENVIRONMENT'] ??
                         getenv('APP_ENVIRONMENT') ?:
                                 self::APP_ENV_PRODUCTION;
        $this->dbDsn = $env['db_dsn'] ?? getenv('db_dsn') ?: '';
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
     * @return string
     */
    public function getDbDsn(): string
    {
        return $this->dbDsn;
    }
}