<?php

namespace App\Core;

class Environment
{
    public const APP_ENV_DEVELOPMENT = 'development';
    public const APP_ENV_PRODUCTION = 'production';

    private string $profile = self::APP_ENV_PRODUCTION;
    private string $baseUrl = '';
    private DbConnector $dbConnector;

    /**
     * AppEnvironment constructor.
     */
    public function __construct()
    {
        $this->profile = getenv('APPLICATION_ENV') ?: self::APP_ENV_PRODUCTION;
        $this->baseUrl = getenv('BASE_URL') ?: '';
        $this->dbConnector = new DbConnector(getenv('DB_LINK') ?: '');
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
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return DbConnector
     */
    public function getPdoConnector(): DbConnector
    {
        return $this->dbConnector;
    }
}