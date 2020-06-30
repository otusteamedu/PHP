<?php

namespace Otus\RYakubov;

use Otus\RYakubov\Config;

class Client
{
    /**
     * Unix socket
     * @var false|resource
     */
    protected $socket;


    function __construct()
    {
        // Socket to push client data
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($this->socket, Config::getSocketName());
    }

    /**
     * Listen STDIN
     */
    public function listenInput()
    {

        while (true) {
            $line = fgets(STDIN);

            // Socket to listen response
            $responseSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            socket_bind($responseSocket, Config::getResponseSocketName());
            socket_listen($responseSocket);

            // Push input data to server
            socket_write($this->socket, $line);

            // Listen for server response
            $respConnectSocket = socket_accept($responseSocket);
            $responseData = socket_read($respConnectSocket, 100);
            echo $responseData;
            socket_close($respConnectSocket);
            socket_close($responseSocket);
            unlink(Config::getResponseSocketName());

            // Terminate application
            if (strpos($line, 'exit') !== false) {
                socket_close($this->socket);

                break;
            }
        }
    }
}
