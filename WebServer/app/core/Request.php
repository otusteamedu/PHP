<?php


namespace Core;


class Request
{
    private array $get;
    private array $post;
    private array $server;
    private static ?Request $instance = null;

    private function __construct(array $get, array $post, array $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    public static function getInstance() : self
    {
        if(!is_null(self::$instance)){
            return self::$instance;
        }

        self::$instance = new self($_GET, $_POST, $_SERVER);

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
    public function getServer(): array
    {
        return $this->server;
    }
}