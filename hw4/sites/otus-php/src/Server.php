<?php

namespace App;

class Server
{
    private $config;
    private $serverSocketPath;

    public function __construct($configPath)
    {
        $this->config = parse_ini_file($configPath);
        $this->serverSocketPath = $this->config['server_socket'];
    }

    public function runServer()
    {
        if (file_exists($this->serverSocketPath)) {
            unlink($this->serverSocketPath);
        }
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!is_resource($socket)) {
            die(socket_strerror(socket_last_error($socket)));
        }
        if (!socket_bind($socket, $this->serverSocketPath)) {
            die(socket_strerror(socket_last_error($socket)));
        }
        if (!socket_listen($socket)) {
            die(socket_strerror(socket_last_error($socket)));
        }
        echo "Ready for connection\n";
        while (true) {
            /** @var Resource|bool $acceptSocket */
            $acceptSocket = socket_accept($socket);
            if (is_resource($acceptSocket)) {
                echo "New connection from {$acceptSocket}\n";
            } else {
                die(socket_strerror(socket_last_error($socket)));
            }
            while (true) {
                $clientRequest = trim(socket_read($acceptSocket, 2048));
                if ($clientRequest == '') {
                    echo "{$acceptSocket} disconnected\n";
                    break;
                }
                if ($clientRequest == 'exit') {
                    if (!socket_write($acceptSocket, "bye-bye!\n")) {
                        echo socket_strerror(socket_last_error($socket));
                    }
                    break;
                }
                $answerForClient = "You say '{$clientRequest}'\n";
                if (!socket_write($acceptSocket, $answerForClient)) {
                    echo socket_strerror(socket_last_error($socket));
                    break;
                }
            }
            $this->closeSocket($acceptSocket);
        }
        $this->closeSocket($socket);
    }

    public function closeSocket($socket)
    {
        socket_close($socket);
    }
}





