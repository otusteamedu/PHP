<?php

namespace App\Repository\Memcached;

class MemcachedWriteRepository
{
    /**
     * Коннектор для Memcached. Может быть memcache или memcached.
     * Неизвестно, какое будет установлено расширение, для работы с сервером memcached.
     * @var mixed
     */
    private mixed $memcached;

    /**
     * @param mixed $memcached
     */
    public function __construct(mixed $memcached)
    {
        $this->memcached = $memcached;
    }

    /**
     * @param string $key
     * @param string $value
     * @return string
     */
    public function set(string $key, string $value): string
    {
        return $this->memcached->set($key, $value);
    }

}