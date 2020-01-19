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
}