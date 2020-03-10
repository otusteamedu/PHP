<?php

namespace App\Service;

use App\Config;

abstract class BaseService implements ServiceInterface
{
    /** @var Config */
    protected $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    protected function checkRequierments()
    {
        if (!extension_loaded('sockets')) {
            throw new \RuntimeException('The sockets extension is not loaded.');
        }
    }

    protected function getSocketByPath(string $path)
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            throw new \RuntimeException('Unable to create AF_UNIX socket');
        }

        if (!socket_bind($socket, $path)) {
            throw new \RuntimeException('Unable to bind to socket');
        }

        return $socket;
    }

    protected function send($socket, string $message, $recipient)
    {
        $len = strlen($message);
        $bytes_sent = socket_sendto($socket, $message, $len, 0, $recipient);

        if ($bytes_sent == -1) {
            throw new \RuntimeException('An error occured while sending to the socket');
        } elseif ($bytes_sent != $len) {
            throw new \RuntimeException(sprintf(
                '%s bytes have been sent instead of the %s bytes expected',
                $bytes_sent,
                $len
            ));
        }
    }

    protected function receive($socket)
    {
        $buf = '';
        $from = '';

        $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            throw new \RuntimeException('An error occured while receiving from the socket');
        }

        return $buf;
    }

    protected function socketSetBlock($socket)
    {
        if (!socket_set_block($socket)) {
            throw new \RuntimeException('Unable to set blocking mode for socket');
        }
    }

    protected function socketSetNonblock($socket)
    {
        if (!socket_set_nonblock($socket)) {
            throw new \RuntimeException('Unable to set nonblocking mode for socket');
        }
    }

    abstract public function run();
}