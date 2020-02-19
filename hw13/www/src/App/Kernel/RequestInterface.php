<?php


namespace App\Kernel;


interface RequestInterface
{
    /**
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string;

    /**
     * @return array
     */
    public function getAll(): array;
}