<?php

namespace App\Socket;

use App\Socket\Exceptions\SocketException;
use InvalidArgumentException;
use function strlen;

/**
 * Class SocketClient
 *
 * @package App\Socket
 */
class SocketClient extends BaseSocket
{
    /**
     * @param  string  $message
     */
    public function sendMessage(string $message): void
    {
        if (strlen($message) > $this->maxMessageLength) {
            throw new InvalidArgumentException('Переданное сообщение превышает разрешенный размер в ' .
                $this->maxMessageLength . ' байт');
        }

        $this->connect();
        $this->write($message);
    }

    /**
     * @throws SocketException
     */
    protected function init(): void
    {
        $this->create();
    }
}