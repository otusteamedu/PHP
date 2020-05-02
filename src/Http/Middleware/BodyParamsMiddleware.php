<?php

namespace Bjlag\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BodyParamsMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $contentType = $request->getHeaderLine('Content-Type');

        $parts = explode(';', $contentType);
        $mime = trim(array_shift($parts));
        $parsedBody = [];

        if (preg_match('#[/]+json$#', $mime)) {
            $rawBody = $request->getBody()->getContents();
            $parsedBody = json_decode($rawBody, true);

            if (!empty($rawBody) && json_last_error()) {
                throw new \InvalidArgumentException('Error when parsing JSON request body: ' . json_last_error_msg());
            }
        }

        return $handler->handle($request->withParsedBody($parsedBody));
    }
}
