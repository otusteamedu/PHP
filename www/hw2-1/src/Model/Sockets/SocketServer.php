<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

class SocketServer extends Socket implements ISocketServer
{
    private int $max_clients = 1;
    private int $check_timeout = 1;

    public function __construct()
    {
        parent::__construct();
    }

    public function bind(string $address, int $port = 0): bool
    {
        $this->setAddress($address);

        $socket = $this->getInstance();

        if (!$this->prepareForBind()) {
            return false;
        }

        try {
            if (!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception('Socket error: [$errorcode] $errormsg');
                //TODO: Loging
                return false;
            }
        } catch (\Exception $e) {
            //TODO: Loging
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

    public function set_nonblock(): bool
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

    public function acceptConnection()
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

    public function writeMsg($client, string $msg): int
    {
        try {
            if (!($bytes = socket_write($client, $msg))) {
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

    public function readMsg($client): ?string
    {
        try {
            if (!($data = socket_read($client, $this->read_buf, $this->read_type))) {
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

    public function shutdownClient($client): bool
    {
        try {
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

    public function getChangesCount(array &$read, ?array &$write, ?array &$except): int
    {
        $tv_sec = $this->getCheckTimeout();

        try {
            if (($con = socket_select($read, $write, $except, $tv_sec)) === false) {
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

    public function getMaxClientsCount(): int
    {
        return $this->max_clients;
        return $this;
    }

    public function setMaxClientsCount(int $max_clients)
    {
        $this->max_clients = $max_clients;
        return $this;
    }

    public function setCheckTimeout(int $check_timeout)
    {
        $this->check_timeout = $check_timeout;
        return $this;
    }

    public function getCheckTimeout(): int
    {
        return $this->check_timeout;
    }
}
