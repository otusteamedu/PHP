<?php


namespace App\Api;


interface StorageInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name);

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, $value);
}