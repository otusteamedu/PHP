<?php


namespace App;


class Router
{
    public const METHODS = [
        'GET'  => 'GET',
        'POST' => 'POST'
    ];

    private static $routes = [
        self::METHODS['GET']  => [],
        self::METHODS['POST'] => [],
    ];

    public static function get(string $rule, \Closure $callback)
    {
        self::add(self::METHODS['GET'], $rule, $callback);
    }

    public static function post(string $rule, \Closure $callback)
    {
        self::add(self::METHODS['POST'], $rule, $callback);
    }

    private static function add(string $method, string $rule, \Closure $callback)
    {
        self::$routes[$method][$rule] = $callback;
    }

    public function route()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        if (array_key_exists($uri, self::$routes[$method])) {
            return (self::$routes[$method][$uri])();
        } else {
            foreach (self::$routes[$method] as $rule => $closure) {
                if (preg_match('/' . str_replace('/', '\/', $rule,) . '/', $uri)) {
                    return $closure();
                }
            }
        }
    }
}