<?php

namespace App\Core;

class Router
{
    private Handler $handler;

    /**
     * @var Handler[] $handlers
     */
    private static array $handlers = [];

    /**
     * RequestRouter constructor.
     * @param string $reqStr
     */
    public function __construct(string $reqStr)
    {
        $this->handler = self::getHandlerByReq($reqStr);
    }

    /**
     * @param string        $reqStr
     * @param string        $method
     * @param callable|null $function
     * @return Handler
     */
    public static function addHandler(
        string $reqStr,
        string $method = 'GET',
        ?callable $function = null
    ): Handler {
        $handler = new Handler(
            $reqStr, $method, $function
        );
        self::$handlers[self::getReqKey($reqStr, $method)] = $handler;
        return $handler;
    }

    /**
     * @param Bootstrap $app
     * @throws AppException
     */
    public function runHandler(Bootstrap $app)
    {
        if ($this->handler instanceof Handler) {
            call_user_func($this->handler->getFunction(), $app);
        }
    }

    /**
     * @return bool
     */
    public function handlerExists(): bool
    {
        return $this->handler instanceof Handler;
    }

    /**
     * @param string $requestStr
     * @return Handler|null
     */
    private static function getHandlerByReq(string $requestStr): ?Handler
    {
        return self::$handlers[self::getReqKey(
                $requestStr,
                $_SERVER['REQUEST_METHOD'] ?? 'GET'
            )] ?? new Handler(
                   '', '', fn(Bootstrap $app) => $app->getResponse()->setBody(
                   "{$requestStr} not found"
               )->setStatusCode(404)
               );
    }

    /**
     * @param string $req
     * @param string $method
     * @return string
     */
    private static function getReqKey(string $req, string $method): string
    {
        return implode(' ', [strtoupper($method), $req]);
    }
}