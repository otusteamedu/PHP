<?php

namespace Otus\socket;


use Otus\config\Config;

abstract class Socket
{
    protected $socket;
    protected $config;

    public function __construct()
    {
        $config = Config::readConfig();
        if (is_array($config)) {
            $this->config=$config['socket'];
        }
        $this->socket = socket_create(AF_UNIX,SOCK_STREAM,0);
        if (!$this->socket) {
            throw new \Exception("Can't create socket");
        }
    }

    public function __destruct()
    {
        socket_shutdown($this->socket,2);
        socket_close($this->socket);
    }

    protected function displayCliMessage($message)
    {
        echo "$message\n";
    }

    public abstract function run();
}