<?php

namespace App;

class Request
{
    private $get = [];

    public function __construct(array $request)
    {
        $this->get = $request;
    }

    public function get(string $key)
    {
        return isset($this->get[$key]) ? $this->get[$key] : null ;
    }
}