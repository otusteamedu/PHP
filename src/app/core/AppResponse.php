<?php

namespace Core;

class AppResponse
{
    public $code = 200;
    public $type = "text/html";
    public $content = "";

    public function __construct(?string $content = "", ?int $code = 200)
    {
        $this->content = $content;
        $this->code = $code;
    }

    public function flush($code = null)
    {
        header("HTTP/1.1 " . ($code ?? $this->code));
        header("Content-Type: {$this->type}");
        echo $this->content;
    }
}