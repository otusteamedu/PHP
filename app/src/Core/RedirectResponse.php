<?php


namespace App\Core;


class RedirectResponse extends Response
{
    protected string $content;
    protected int $code;
    protected array $headers;

    public function __construct(string $url, int $code = 301, array $headers = [])
    {
        $this->content = 'Redirecting to ' . $url;
        $this->code = $code;
        $this->headers = array_merge(['Location: ' . $url], $headers);

        parent::__construct($this->content, $this->code, $this->headers);
    }
}