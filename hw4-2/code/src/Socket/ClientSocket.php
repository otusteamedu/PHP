<?php
declare(strict_types=1);

namespace App\Socket;

use App\Socket\Exception\SocketException;

/**
 * Class ClientSocket
 */
class ClientSocket extends AbstractSocket
{
    /**
     * @param string $address
     *
     * @return void
     *
     * @throws SocketException When unable to connect to socket.
     */
    public function connect(string $address): void
    {
        if (!socket_connect($this->socket, $address)) {
            throw $this->createExceptionWithErrorCode('Unable to connect to socket');
        }
    }
}
