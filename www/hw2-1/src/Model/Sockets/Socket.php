<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets;

use Nlazarev\Hw2_1\Model\Sockets\Traits\hasUnixSocket;

abstract class Socket implements ISocket
{
    use hasUnixSocket;

    private $instance = null;
    private bool $is_ext_loaded = false;
    private bool $is_created = false;
    private string $address = "";
    private int $port = 0;
    protected int $send_flags = MSG_DONTROUTE;
    protected int $read_buf = 2048;
    protected int $read_type = PHP_BINARY_READ;

    protected function createSocketInstance()
    {
        $this->setInstance($this->createUnixSocket());
    }

    protected function prepareForBind(): bool
    {
        return $this->preparePath($this->address);
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

    public function isExtLoaded(): bool
    {
        if ($this->is_ext_loaded) {
            return true;
        } else
            return false;
    }

    public function isCreated(): bool
    {
        if ($this->is_created) {
            return true;
        } else
            return false;
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

    public function close()
    {
        try {
            socket_close($this->getInstance());
        } catch (\Exception $e) {
            //TODO: Loging
        }
    }

    public function setSendFlags(int $send_flags)
    {
        $this->send_flags = $send_flags;
        return $this;
    }

    public function setReadBuf(int $read_buf)
    {
        $this->read_buf = $read_buf;
        return $this;
    }

    public function setReadType(int $read_type)
    {
        $this->read_type = $read_type;
        return $this;
    }

    protected function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }
}
