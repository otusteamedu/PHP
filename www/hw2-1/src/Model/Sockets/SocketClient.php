<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

final class SocketClient extends Socket implements ISocketClient
{
    private bool $is_connected = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function connect(string $address, int $port = 0): bool
    {
        $this->setAddress($address)
            ->setPort($port);

        $socket = $this->getInstance();

        try {
            if (!($this->is_connected = socket_connect($socket, $address, $port))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception('Socket error: [$errorcode] $errormsg');
                //TODO: Loging
            }
        } catch (\Exception $e) {
            //TODO: Loging
        }

        return $this->is_connected;
    }

    public function isConnected(): bool
    {
        if ($this->is_connected) {
            return true;
        } else {
            return false;
        }
    }

    public function write($socket, string $buffer, int $write_length = 2048): int
    {
        try {
            if (!($bytes = socket_write($socket, $buffer, $write_length))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception("Socket error: [$errorcode] $errormsg");
                $bytes = 0;
                //TODO: Loging
            }
        } catch (\Exception $e) {
            $bytes = 0;
            //TODO: Loging
        }

        return $bytes;
    }

    public function read($socket, int $length = 2048, int $type = PHP_BINARY_READ): ?string
    {
        $socket = $this->getInstance();

        try {
            if (!($data = socket_read($socket, $length, $type))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception('Socket error: [$errorcode] $errormsg');
                //TODO: Loging
                return null;
            } else {
                return $data;
            }
        } catch (\Exception $e) {
            //TODO: Loging
            return null;
        }
    }
}
