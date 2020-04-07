<?php

namespace Bjlag\Http;

use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

class Request
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';

    /** @var \Bjlag\Http\Request */
    private static $instance;

    /** @var \Psr\Http\Message\ServerRequestInterface */
    private $request;

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    private function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return static
     */
    public static function fromGlobals(): self
    {
        if (self::$instance === null) {
            self::$instance = new self(ServerRequestFactory::fromGlobals());
        }

        return self::$instance;
    }

    /**
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    public function get(): ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->request->getMethod() === self::METHOD_POST;
    }
}
