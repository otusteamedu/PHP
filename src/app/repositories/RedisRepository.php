<?php

namespace Repository;

use Core\AppConfig;
use Core\AppException;
use Exception;
use Filter\EventsFilter;
use Filter\RedisFilter;
use Redis;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class RedisRepository extends CommonRepository
{

    /** @var Redis $store */
    protected static Redis $store;

    /**
     * RedisRepository constructor.
     * @param mixed $init
     */
    public function __construct($init = null)
    {
        if (is_array($init)) {
            $this->buildFromArray($init);
        }
    }

    /**
     * @param AppConfig $appConfig
     * @throws AppException
     */
    public static function initStore(AppConfig $appConfig)
    {
        self::$store = new Redis();
        try {
            if (!self::$store->isConnected()) {
                self::$store->connect($appConfig->getRedisHost(), $appConfig->getRedisPort());
                self::$store->select($appConfig->getRedisDb());
            }
        } catch (Exception $e) {
            throw new AppException("Unreachable connection Redis service");
        }
    }

    /**
     * @return array
     */
    abstract public function fetchDocument(): array;

    /**
     * @return string
     */
    abstract protected function getKey(): string;
}