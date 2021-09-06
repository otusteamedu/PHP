<?php

namespace App\Repository\Memcached;

class MemcachedReadRepository
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
     * @return string
     */
    public function get(string $key): string
    {
        return $this->memcached->get($key);
    }

    public function getInfo():array
    {
        return (class_exists('Memcache'))
            ? $this->memcached->getStats()
            : $this->memcached->getStats()[$this->config['host'] . ":" . $this->config['port']];
    }
}