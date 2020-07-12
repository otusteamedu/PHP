<?php

namespace App;

class Config
{
    private $path;
    private $items;

    /**
     * @param string $path
     */
    public function __construct(string $path) {
        $this->path = $path;
    }

    /**
     * @param string $key
     * @param string $filename
     */
    public function add(string $key, string $filename) {
        $this->items[$key] = $filename;
    }

    /**
     * @param string $filename
     */
    public function get(string $filename) {
        return require_once $this->path . $this->items[array_search($filename, $this->items)] . '.php';
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool {
        return array_key_exists($key, $this->items);
    }
}