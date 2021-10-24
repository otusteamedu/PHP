<?php

namespace Routes;


class PreparedArgs
{
    private static string $uriRequest;

    public function __construct()
    {
        self::$uriRequest = $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public static function getUriRequest(): string
    {
        return self::$uriRequest;
    }

    /**
     * @param string $uriRequest
     */
    public static function setUriRequest(string $uriRequest): void
    {
        self::$uriRequest = $uriRequest;
    }

}