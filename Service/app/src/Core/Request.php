<?php


namespace Service\Core;


class Request
{
    private array $request;
    private array $server;
    private static ?Request $instance = null;

    private function __construct(array $request, array $server)
    {
        $this->request = $request;
        $this->server = $server;
    }

    public static function getInstance() : self
    {
        if(!is_null(self::$instance)){
            return self::$instance;
        }

        self::$instance = new self($_REQUEST, $_SERVER);

        return self::$instance;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->request;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        return $this->request[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }
}