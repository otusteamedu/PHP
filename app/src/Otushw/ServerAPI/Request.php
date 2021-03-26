<?php


namespace Otushw\ServerAPI;

use GuzzleHttp\Psr7\ServerRequest;
use Otushw\Exception\AppException;
use Psr\Http\Message\ServerRequestInterface;
use Exception;

class Request
{
    private static $request = null;

    private function __construct() { }

    private function __clone() { }

    private function __wakeup() { }

    public static function getInstance(): ServerRequestInterface
    {
        if (self::$request != null) {
            return self::$request;
        }
        self::$request = self::create();
        return self::$request;
    }

    private static function create(): ServerRequestInterface
    {
        try {
            $request = ServerRequest::fromGlobals();
            return $request;
        } catch (Exception $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }
    }
}