<?php

namespace Core;

class AppConfig extends RowStructureObject
{
    public const ENV_DEVELOPMENT = "development";
    public const ENV_PRODUCTION = "production";

    protected string $env = self::ENV_PRODUCTION;
    protected string $mongoDbUrl = "";
    protected string $mongoDbName = "";
    protected string $redisHost = "";
    protected int $redisPort = 6379;
    protected int $redisDb = 0;
    protected string $youtubeApiKey = "";

    /**
     * @return bool
     */
    public function isProduction(): bool
    {
        return $this->env === self::ENV_PRODUCTION;
    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }

    /**
     * @return string
     */
    public function getMongoDbUrl(): string
    {
        return $this->mongoDbUrl;
    }

    /**
     * @return string
     */
    public function getMongoDbName(): string
    {
        return $this->mongoDbName;
    }

    /**
     * @return string
     */
    public function getRedisHost(): string
    {
        return $this->redisHost;
    }

    /**
     * @return int
     */
    public function getRedisPort(): int
    {
        return $this->redisPort;
    }

    /**
     * @return int
     */
    public function getRedisDb(): int
    {
        return $this->redisDb;
    }

    /**
     * @return string
     */
    public function getYoutubeApiKey(): string
    {
        return $this->youtubeApiKey;
    }
}