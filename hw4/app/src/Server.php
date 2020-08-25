<?php


namespace App;


use App\Socket\Socket;
use Exception;

class Server extends Socket
{
    public function __construct($iniFilepath)
    {
        parent::__construct($iniFilepath);

        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }
        if (socket_bind($this->socket, $this->socketPath) === false) {
            return new Exception('failed to bind to socket');
        }
        if (socket_listen($this->socket, 1) === false) {
            return new Exception('failed to listen to socket');
        }
    }

    public function start()
    {
        $socket = socket_accept($this->socket);
        $message = socket_read($socket, 512);
        if ($message === self::SOCKET_DOWN) {
            $this->downSocket();
            echo "Socket is down. Bay.\n";
            exit();
        }
        echo "Message: {$message} \n";
    }
}