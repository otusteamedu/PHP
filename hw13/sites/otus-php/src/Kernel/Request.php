<?php

declare(strict_types=1);

namespace App\Kernel;

class Request implements RequestInterface
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

    public function getAll(): array
    {
        $result = [];
        foreach ($this->get as $argName => $argValue) {
            if ($argName == 'uri') {
                continue;
            }

            $result[$argName] = $argValue;
        }

        return $result;
    }
}