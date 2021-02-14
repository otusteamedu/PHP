<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

final class SocketServer extends Socket implements ISocketServer
{
    private int $check_timeout = 1;
    private ?array $read_sockets = null;
    private ?array $write_sockets = null;
    private ?array $except_sockets = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function bind(string $address, int $port = 0): bool
    {
        $socket = $this->getInstance();

        $this->setAddress($address)
            ->setPort($port);

        if (!$this->prepareForBind()) {
            return false;
        }

        try {
            if (!($res = socket_bind($socket, $address, $port))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception('Socket error: [$errorcode] $errormsg');
                //TODO: Loging
            }
        } catch (\Exception $e) {
            //TODO: Loging
        }

        return $res;
    }

    protected function prepareForBind(): bool
    {
        if ($this->getSocketType() == AF_UNIX) {
            if (!$this->preparePath($this->address)) {
                return false;
            }
        }

        if (!$this->setOption(SOL_SOCKET, SO_REUSEADDR, 1)) {
            return false;
        }

        return true;
    }

    public function listen(int $listen_backlog): bool
    {
        $socket = $this->getInstance();

        try {
            if (!($res = socket_listen($socket, $listen_backlog))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception("Socket error: [$errorcode] $errormsg");
                //TODO: Loging
            }
        } catch (\Exception $e) {
            //TODO: Loging
        }

        return true;
    }

    public function setNonBlock(): bool
    {
        $socket = $this->getInstance();

        try {
            if (!($res = socket_set_nonblock($socket))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception("Socket error: [$errorcode] $errormsg");
                //TODO: Loging
            }
        } catch (\Exception $e) {
            //TODO: Loging
        }

        return $res;
    }

    public function accept()
    {
        $socket = $this->getInstance();

        try {
            if (!($con = socket_accept($socket))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception("Socket error: [$errorcode] $errormsg");
                $con = null;
                //TODO: Loging
            }
        } catch (\Exception $e) {
            $con = null;
            //TODO: Loging
        }

        return $con;
    }

    public function shutdownClient($client): bool
    {
        try {
            if (($key = array_search($client, $this->read_sockets)) !== false) {
                unset($this->read_sockets[$key]);
            }

            if (!($res = socket_shutdown($client, 2))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception('Socket error: [$errorcode] $errormsg');
                //TODO: Loging
            }
        } catch (\Exception $e) {
            //TODO: Loging
        }

        return $res;
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

    public function getChangesCount(): int
    {
        $tv_sec = $this->getCheckTimeout();

        try {
            if (
                ($con = socket_select(
                    $this->read_sockets,
                    $this->write_sockets,
                    $this->except_sockets,
                    $tv_sec
                )) === false
            ) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception("Socket error: [$errorcode] $errormsg");
                $con = 0;
                //TODO: Loging
            }
        } catch (\Exception $e) {
            //TODO: Loging
            $con = 0;
        }
        return $con;
    }

    public function getReadSockets(): array
    {
        return $this->read_sockets;
    }

    public function addSocketToRead($socket)
    {
        $this->read_sockets[] = &$socket;
    }

    public function getCheckTimeout(): int
    {
        return $this->check_timeout;
    }

    public function setCheckTimeout(int $check_timeout)
    {
        $this->check_timeout = $check_timeout;
        return $this;
    }
}
