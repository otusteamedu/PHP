<?php


namespace v2\Services\Storage;


interface Storage
{
    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set(string $key, $value, int $ttl = 0): bool;

    public function get(string $key, $default = null);

    public function clear() : void;
}