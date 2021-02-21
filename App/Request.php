<?php


namespace App;


class Request
{
    //TODO: fill another
    const METHODS = [
        'POST' => 'POST',
        'GET'  => 'GET',
    ];
    private $method;
    private static $instance = null;

    private function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public static function getInstance(): Request
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function getMethod()
    {
        return self::getInstance()->method;
    }

    public static function isPost()
    {
        return self::getMethod() === self::METHODS['POST'];
    }

    public static function isGet()
    {
        return self::getMethod() === self::METHODS['GET'];
    }
}