<?php

declare(strict_types=1);

namespace App\Kernel;

class Request
{
    private $get = [];

    public function __construct()
    {
        $this->get = $_GET;
    }

    public function get(string $key): ?string
    {
        return isset($this->get[$key]) ? $this->get[$key] : null ;
    }

    public function has(string $key): bool
    {
        return isset($this->get[$key]) ? true : false ;
    }

    public function isTrue(string $key): bool
    {
        return $this->get($key) == true  ? true : false ;
    }
}