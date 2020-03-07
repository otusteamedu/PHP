<?php

namespace Bjlag;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Response
{
    /** @var int */
    private $code;

    /** @var array */
    private $headers;

    /** @var string */
    private $body;

    /**
     * @param int $code
     * @param array $headers
     * @param null $body
     */
    public function __construct(int $code, array $headers = [], $body = null)
    {
        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return $this
     */
    public function withServerName(ServerRequestInterface $request): self
    {
        $serverParams = $request->getServerParams();
        $serverName = $serverParams['SERVER_NAME'] ?? 'Undefined server';

        if ($this->body !== null && is_string($this->body)) {
            $this->body .= "<br><br><hr><br>";
        }

        $this->body .= "Ответил сервер: {$serverName}";

        return $this;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(): ResponseInterface
    {
        return new \Nyholm\Psr7\Response($this->code, $this->headers, $this->body);
    }
}
