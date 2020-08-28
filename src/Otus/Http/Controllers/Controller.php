<?php

namespace Otus\Http\Controllers;

abstract class Controller
{
    protected function get(string $key, $default = null)
    {
        if (array_key_exists($key, $_GET)) {
            return $_GET[$key];
        }
        return $default;
    }

    protected function post(string $key, $default = null)
    {
        if (array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
        return $default;
    }

    protected function response(string $data, $status = 200): void
    {
        echo $data;
        http_response_code($status);
    }
}