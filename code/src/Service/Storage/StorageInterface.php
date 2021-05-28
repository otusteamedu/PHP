<?php

namespace App\Service\Storage;

interface StorageInterface
{
    /**
     * Returns the contents of storage
     * @return array|mixed|null
     */
    public function get(string $key);

    /**
     * Writes $contents to storage
     *
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void;

    /**
     * Clears contents from storage
     * @param null $key
     */
    public function clear($key): void;

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool;
}
