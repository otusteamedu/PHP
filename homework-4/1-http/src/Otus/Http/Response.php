<?php

namespace Otus\Http;

class Response
{
    public const HTTP_OK = 200;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_FOUND = 404;

    private const HTTP_STATUSES = [
        200 => 'OK',
        400 => 'Bad Request',
        404 => 'Not Found',
    ];

    private int $code;

    private string $content;

    public function __construct(int $code = 200, string $content = null)
    {
        $this->code    = $code;
        $this->content = $content ?? static::HTTP_STATUSES[$this->code];
    }

    public function send(): void
    {
        http_response_code($this->code);

        echo $this->content;

        fastcgi_finish_request();
    }
}
