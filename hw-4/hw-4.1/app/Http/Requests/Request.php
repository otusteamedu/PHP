<?php

namespace App\Http\Requests;

class Request
{
    public function post($key = null)
    {
        return array_key_exists($key, $_POST) ? $_POST[$key] : null;
    }

    public function get($key)
    {
        return array_key_exists($key, $_GET) ? $_GET[$key] : null;
    }

}
