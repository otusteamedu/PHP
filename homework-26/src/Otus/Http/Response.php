<?php

namespace Otus\Http;

class Response implements ResponseContract
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    protected const HTTP_STATUSES = [
        200 => 'OK',
        400 => 'Bad Request',
        404 => 'Not Found',
    ];

    protected int $code;

    protected ?string $content;

    protected array $headers = [];

    public function __construct(int $code = 200, string $content = null)
    {
        $this->code    = $code;
        $this->content = $content ?? static::HTTP_STATUSES[$this->code];
    }

    public function headers(array $headers): void
    {
        $this->headers = array_merge($this->headers, $headers);
        $this->headers = array_filter($this->headers);
    }

    public function header($key, $value): void
    {
        $this->headers([$key => $value]);
    }

    public function send(): void
    {
        http_response_code($this->code);

        $this->sendHeaders();

        if ($this->content !== null) {
            echo $this->content;
        }

        fastcgi_finish_request();
    }

    protected function sendHeaders(): void
    {
        if (empty($this->headers)) {
            return;
        }

        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }
}
