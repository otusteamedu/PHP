<?php

namespace App\Factory;

use App\Http\Request\Request;
use App\Interfaces\RequestInterface;

class RequestFactory
{
    public static function createRequest(string $method, string $url): RequestInterface {
        return new Request($method, $url);
    }

    public static function createRequestFromGlobals(): RequestInterface {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $query = $_GET;
        $parameters = $_POST;
        $request = new Request($method, $uri);
        $request->setParameters($parameters);
        $request->setQuery($query);

        return $request;
    }
}