<?php


namespace App\Core;


class Response
{
    protected string $content;
    protected int $code;
    protected array $headers;

    public function __construct(string $content, int $code = 200, array $headers = [])
    {
        $this->content = $content;
        $this->code = $code;
        $this->headers = $headers;
    }

    public function __toString() : string
    {
       return $this->__invoke();
    }

    public function __invoke() : string
    {
        $this->setHeaders();
        $this->setCode();

        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    protected function setHeaders() : void
    {
        foreach ($this->headers as $header){
            header($header);
        }
    }

    protected function setCode() : void
    {
        http_response_code($this->code);
    }
}