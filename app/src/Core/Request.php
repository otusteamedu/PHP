<?php


namespace App\Core;


class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $request;
    private static ?Request $instance = null;

    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';

    private function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
        $this->server = $_SERVER;
    }

    public static function getInstance() : self
    {
        if(!is_null(self::$instance)){
            return self::$instance;
        }

        self::$instance = new self();

        return self::$instance;
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
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }

    public function isGet() : bool
    {
        return $this->server['REQUEST_METHOD'] === self::GET_METHOD;
    }

    public function isPost() : bool
    {
        return $this->server['REQUEST_METHOD'] === self::POST_METHOD;
    }

    public function getRequestUri() : string
    {
        return $this->server['REQUEST_URI'];
    }

    public function getQueryString() : string
    {
        return $this->server['QUERY_STRING'];
    }

    public function get(string $param, $default = null) : ?string
    {
        return $this->getRequest()[$param] ?? $default;
    }
}