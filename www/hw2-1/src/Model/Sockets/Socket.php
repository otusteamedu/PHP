<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

use Nlazarev\Hw2_1\Model\Sockets\Traits\HasUnixSocket;

abstract class Socket implements ISocket
{
    use HasUnixSocket;

    private int $socket_type = AF_UNIX;
    private $instance = null;
    private bool $is_ext_loaded = false;
    private bool $is_created = false;
    protected ?string $address = null;
    protected int $port = 0;

    protected function createSocketInstance()
    {
        switch ($this->getSocketType()) {
            case AF_UNIX:
                $this->setInstance($this->createUnixSocket());
                break;
            default:
                $this->setInstance(null);
        }
    }

    protected function __construct()
    {
        if (!($this->is_ext_loaded = extension_loaded(self::SOCKET_EXT_NAME))) {
            throw new \Exception('Socket error: extension "' . self::SOCKET_EXT_NAME . '" not loaded \n');
            //TODO: Loging
        }

        if ($this->isExtLoaded()) {
            $this->createSocketInstance();
        }

        if (!($this->is_created = !is_null($this->getInstance()))) {
            throw new \Exception('Socket error: Socket resource is null');
            //TODO: Loging
        }
    }

    public function getSocketType(): int
    {
        return $this->socket_type;
    }

    public function isExtLoaded(): bool
    {
        if ($this->is_ext_loaded) {
            return true;
        } else {
            return false;
        }
    }

    public function isCreated(): bool
    {
        if ($this->is_created) {
            return true;
        } else {
            return false;
        }
    }

    public function getInstance()
    {
        return $this->instance;
    }

    protected function setInstance($instance)
    {
        if (is_resource($instance)) {
            if (get_resource_type($instance) == 'Socket') {
                $this->instance = $instance;
            }
        }
    }

    protected function setOption(int $level, int $optname, $optval): bool
    {
        $socket = $this->getInstance();

        try {
            if (!socket_set_option($socket, $level, $optname, $optval)) {
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

        return true;
    }

    public function close()
    {
        try {
            socket_close($this->getInstance());
        } catch (\Exception $e) {
            //TODO: Loging
        }
    }

    protected function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }

    protected function setPort(int $port)
    {
        $this->port = $port;
        return $this;
    }
}
