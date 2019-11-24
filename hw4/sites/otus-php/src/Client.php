<?php

namespace App;

class Client
{
    private $config;
    private $serverSocketPath;

    public function __construct($configPath)
    {
        $this->config = parse_ini_file($configPath);
        $this->serverSocketPath = $this->config['server_socket'];
    }

    public function runClient()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!socket_connect($socket, $this->serverSocketPath)) {
            die(socket_strerror(socket_last_error($socket)));
        }
        echo "Write your message than press Enter. \nWrite 'exit' for stop application\n";
        $stdin = fopen('php://stdin', 'r');
        while (true) {
            $line = fgets($stdin, 2048);
            if (trim($line) == 'exit') {
                echo $this->sendToServer($socket, $line);
                break;
            }
            echo $this->sendToServer($socket, $line);
        }
    }

    public function sendToServer($socket, $data)
    {
        if (!socket_write($socket, $data)) {
            die(socket_strerror(socket_last_error($socket)));
        }

        return socket_read($socket, 2048);
    }
}





