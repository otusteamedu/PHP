<?php

namespace App\Models;


use App\Exceptions\Checkers\InvalidCheckerException;
use App\Helpers\ConfigHelper;
use App\Services\Checkers\AbstractChecker;
use App\Services\Checkers\ErrorChecker;
use App\Services\Checkers\Inspector;
use App\Services\Checkers\NoSql\ElasticsearchChecker;
use App\Services\Checkers\NoSql\MemcachedChecker;
use App\Services\Checkers\NoSql\RedisChecker;
use Exception;


class NoSqlModel implements IModel
{

    /**
     * @return AbstractChecker
     */
    public function checkRedis(): AbstractChecker
    {
        try {
            return Inspector::check(RedisChecker::class, ConfigHelper::getConnectionConfigRedis());
        } catch (InvalidCheckerException $ex) {
            return new ErrorChecker($ex->getCode(), 'System Error: ' . $ex->getMessage());
        } catch (Exception $ex) {
            return new ErrorChecker($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * @return AbstractChecker
     */
    public function checkElasticsearch(): AbstractChecker
    {
        try {
            return Inspector::check(ElasticsearchChecker::class, ConfigHelper::getConnectionConfigElasticsearch());
        } catch (InvalidCheckerException $ex) {
            return new ErrorChecker($ex->getCode(), 'System Error: ' . $ex->getMessage());
        } catch (Exception $ex) {
            return new ErrorChecker($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * @param string $serverName
     * @return AbstractChecker
     */
    public function checkMemcached(string $serverName): AbstractChecker
    {
        try {
            return match ($serverName) {
                'memcached'   => Inspector::check(MemcachedChecker::class, ConfigHelper::getConnectionConfigMemCached()),
                'memcached-1' => Inspector::check(MemcachedChecker::class, ConfigHelper::getConnectionConfigMemCached1()),
                'memcached-2' => Inspector::check(MemcachedChecker::class, ConfigHelper::getConnectionConfigMemCached2()),
            };
        } catch (InvalidCheckerException $ex) {
            return new ErrorChecker($ex->getCode(), 'System Error: ' . $ex->getMessage());
        } catch (Exception $ex) {
            return new ErrorChecker($ex->getCode(), $ex->getMessage());
        }
    }
}