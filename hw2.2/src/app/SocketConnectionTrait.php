<?php

namespace App;

use Exception;

/**
 * Trait SocketConnectionTrait
 * @package App
 */
trait SocketConnectionTrait
{
    /**
     * @var
     */
    private $socket;

    /**
     * @return void
     */
    public function createConnection()
    {
        try {
            $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        } catch (\Throwable $e) {
            echo 'Could not create socket: ' . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * @throws Exception
     */
    public function bindSocket()
    {
        echo 'Binding socket ' . PHP_EOL;
        $socketFile = Config::SOCKET_FILE;

        if (file_exists($socketFile)) {
            unlink($socketFile);
        }

        if (!socket_bind($this->socket, $socketFile)) {
            throw new Exception('Unable to bind to' . $socketFile);
        }
    }
}