<?php


namespace Src\Http;


class Request
{
    private array $get;
    private array $server;
    private array $session;

    public function __construct(array $get, array $server, array $session)
    {
        $this->get = $get;
        $this->server = $server;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }

    public function isAjax() : bool
    {
        return !empty($this->server['HTTP_X_REQUESTED_WITH']) &&
            strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * @return array
     */
    public function getSession(): array
    {
        return $this->session;
    }

    public function getRequestUri() : string
    {
        return $this->server['REQUEST_URI'];
    }

    public function getQueryString() : string
    {
        return $this->server['QUERY_STRING'];
    }

}