<?php


namespace Core;


class Request
{
    /** @var string */
    protected $method;

    /** @var array */
    protected $request;

    /** @var array */
    protected $query;

    /** @var array|bool */
    protected $headers;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->request = file_get_contents('php://input');
        $this->query = $_GET;
        $this->headers = getallheaders();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @return array|bool
     */
    public function getHeaders()
    {
        return $this->headers;
    }

}
