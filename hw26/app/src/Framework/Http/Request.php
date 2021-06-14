<?php

declare(strict_types=1);

namespace App\Framework\Http;

class Request implements RequestInterface
{
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUriPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function getPostParam($paramName): string
    {
        return $_POST[$paramName] ?? '';
    }
}