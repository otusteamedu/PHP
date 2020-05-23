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
     * @param string $method
     * @param string $request
     * @param array $query
     * @param array|bool $headers
     */
    public function __construct(string $method, string $request, array $query, $headers)
    {
        $this->method = $method;
        $this->request = $request;
        $this->query = $query;
        $this->headers = $headers;
    }

    public static function create()
    {
        return new self($_SERVER['REQUEST_METHOD'], file_get_contents('php://input'), $_GET, getallheaders());
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
