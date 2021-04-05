<?php
namespace Otus\Azatnizam;

use Otus\Azatnizam\Config;

class Server {
    /**
     * Unix socket
     * @var false|resource
     */
    protected $socket;

    /**
     * Data resource
     * @var resource
     */
    protected $connectSocket;


    public function __construct() {
        // Client socket
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind( $this->socket, Config::getSocketName() );
        socket_listen($this->socket);

        $this->connectSocket = socket_accept($this->socket);
    }

    /**
     * Listen data from client
     */
    public function listenSocket() {

        while (true) {
            $data = socket_read($this->connectSocket, 100);
            echo 'client request: ' . $data;

            // Send response to client via response socket
            $responseSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            socket_connect( $responseSocket, Config::getResponseSocketName() );
            socket_write($responseSocket, 'response: ' . str_replace(PHP_EOL, "", $data) . ' ok' . PHP_EOL);
            socket_close($responseSocket);

            // Terminate server by client command
            if ( strpos($data, 'exit') !== false ) {
                socket_close($this->connectSocket);
                socket_close($this->socket);
                unlink( Config::getSocketName() );
                break;
            }


        }

    }
}
