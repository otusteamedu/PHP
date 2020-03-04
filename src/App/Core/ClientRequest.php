<?php

namespace App\Core;

class ClientRequest
{
    private string $requestStr = '';
    private array $headers = [];
    private string $body = '';
    private array $filters = [];

    /**
     * @return ClientRequest
     */
    public static function getFromHttp(): ClientRequest
    {
        $env = new Environment();

        $req = new self();
        $req->requestStr = str_replace(
            '?' . $_SERVER['QUERY_STRING'],
            '',
            str_replace($env->getBaseUrl(), '/', $_SERVER['REQUEST_URI'])
        );
        $req->body = file_get_contents('php://input');
        $req->filters = $_GET ?? [];
        $req->buildHeaders();
        return $req;
    }

    /**
     * @param string $reqStr
     * @param array  $filters
     * @param string $body
     * @return ClientRequest
     */
    public static function getByReqStr(
        string $reqStr,
        array $filters,
        string $body = ''
    ): ClientRequest {
        $req = new self();
        $req->requestStr = $reqStr;
        $req->filters = $filters;
        $req->body = $body;
        $req->buildHeaders();
        return $req;
    }

    /**
     * @return ClientRequest
     * @throws AppException
     */
    public function validateRequiredParams(): ClientRequest
    {
        $missingParams = array_diff(
            func_get_args(),
            array_keys($this->filters)
        );
        if (!empty($missingParams)) {
            throw new AppException(
                'required params are missing: ' . implode(', ', $missingParams),
                400
            );
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestStr(): string
    {
        return $this->requestStr;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     * @return ClientRequest
     */
    public function setFilters(array $filters): ClientRequest
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * @param string $name
     * @return string|array|null
     */
    public function getFilter(string $name)
    {
        return $this->filters[$name] ?? null;
    }

    /**
     * @param string       $name
     * @param string|array $value
     * @return ClientRequest
     */
    public function setFilter(string $name, $value): ClientRequest
    {
        if (is_string($value) || is_array($value)) {
            $this->filters[$name] = $value;
        }
        return $this;
    }

    private function buildHeaders()
    {
        $this->headers = array_intersect_key(
            $_SERVER,
            array_flip(preg_grep('/^HTTP_/', array_keys($_SERVER), 0))
        );
    }

    /**
     * @param string $requestStr
     * @return ClientRequest
     */
    public function setRequestStr(string $requestStr): ClientRequest
    {
        $this->requestStr = $requestStr;
        return $this;
    }

    /**
     * @param array $headers
     * @return ClientRequest
     */
    public function setHeaders(array $headers): ClientRequest
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $body
     * @return ClientRequest
     */
    public function setBody(string $body): ClientRequest
    {
        $this->body = $body;
        return $this;
    }
}