<?php


namespace Repetitor202;


trait SocketTrait
{
    public $socket = null;
    public $socketFile = null;

    public function createSocket()
    {
        try {
            echo '>>Creating socket ' . PHP_EOL;
            $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
            $this->socketFile = $_ENV['SOCKET_FILE'];
        } catch (\Exception $e) {
            $message = 'Could not create socket ' . $e->getMessage() . PHP_EOL;
            $message .= socket_strerror(socket_last_error()) . PHP_EOL;

            throw new \Exception($message);
        }
    }

    public function bindSocket()
    {
        echo '>>Binding socket ' . PHP_EOL;

        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        if (!socket_bind($this->socket, $this->socketFile)) {
            $message = 'Unable to bind to ' . $this->socketFile . PHP_EOL;
            $message .= socket_strerror(socket_last_error()) . PHP_EOL;

            throw new \Exception($message);
        }
    }
}