<?php
declare(strict_types=1);

namespace Checkers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;

/**
 *
 * @package   Checkers
 */
class CheckerResponser
{
    /**
     * @var ResponseInterface
     */
    private $response;
    /**
     * @var BracketsChecker
     */
    private $bracketsChecker;

    /**
     * @param ResponseInterface $response
     * @param BracketsChecker $bracketsChecker
     */
    public function __construct(ResponseInterface $response, Checker $bracketsChecker)
    {
        $this->response = $response;
        $this->bracketsChecker = $bracketsChecker;
    }

    /**
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __invoke(): ResponseInterface
    {
        $str = "<p>";
        $str .= $this->response->getBody() . "<p>";
        $str .= $this->response->getHeader("string") . "<p>";
//        $str .= $this->response->getHeaderLine() . "<p>";
        $str .= $this->response->getProtocolVersion() . "<p>";
        $str .= $this->response->getReasonPhrase() . "<p>";
        $str .= $this->response->getStatusCode() . "<p>";
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
//            ->write("<html><head></head><body>Hello, " . $str . " world!</body></html>");
            ->write(print_r($response));


        return $response;
    }
}