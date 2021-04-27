<?php


namespace v2\Services\Storage;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;

class RedisStorage implements Storage
{
    protected const DEFAULT_TTL =60*24*30*12; //1 year

    public function set(string $key, $value, $ttl = self::DEFAULT_TTL): bool
    {
        $storage = $this->getStorage();
        return $storage->put($key, $value, $ttl);
    }

    public function get($key, $default = null)
    {
        $storage = $this->getStorage();
        return $storage->get($key) ?? $default;
    }

    public function clear() : void
    {
        $this->getStorage()->flush();
    }

    protected function getStorage() :  Repository
    {
        return Cache::store('redis');
    }
}