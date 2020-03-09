<?php

namespace App\Core;

class Environment
{
    public const APP_ENV_DEVELOPMENT = 'development';
    public const APP_ENV_PRODUCTION = 'production';

    private string $profile = self::APP_ENV_PRODUCTION;
    private string $baseUrl = '';
    private string $ordersApiUrl = 'http://localhost';
    private DbConnector $dbConnector;
    private MqConnector $mqConnector;
    private RedisConnector $redisConnector;

    /**
     * AppEnvironment constructor.
     */
    public function __construct()
    {
        $this->profile = getenv('APPLICATION_ENV') ?: self::APP_ENV_PRODUCTION;
        $this->baseUrl = getenv('BASE_URL') ?: '';
        $this->mqConnector = new MqConnector(getenv('AMQP_LINK') ?: '');
        $this->dbConnector = new DbConnector(getenv('DB_LINK') ?: '');
        $this->redisConnector = new RedisConnector(getenv('REDIS_LINK') ?: '');
        $this->ordersApiUrl = getenv('SELF_API_URL') ?: $this->ordersApiUrl;
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

    /**
     * @return MqConnector
     */
    public function getMqConnector(): MqConnector
    {
        return $this->mqConnector;
    }

    /**
     * @return RedisConnector
     */
    public function getRedisConnector(): RedisConnector
    {
        return $this->redisConnector;
    }

    /**
     * @return string
     */
    public function getOrdersApiUrl(): string
    {
        return $this->ordersApiUrl;
    }
}