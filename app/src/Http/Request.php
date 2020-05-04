<?php


namespace Http;


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
     * @param array $request
     * @param array $query
     * @param array|bool $headers
     */
    public function __construct(string $method, array $request, array $query, $headers)
    {
        $this->method = $method;
        $this->request = $request;
        $this->query = $query;
        $this->headers = $headers;
    }

    public static function create()
    {
        return new self($_SERVER['REQUEST_METHOD'], $_POST, $_GET, getallheaders());
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @param array $request
     */
    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @param array $query
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    /**
     * @return array|bool
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array|bool $headers
     */
    public function setHeaders($headers): void
    {
        $this->headers = $headers;
    }

}
