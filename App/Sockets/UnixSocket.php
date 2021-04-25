<?php


namespace App\Sockets;


class UnixSocket extends Socket
{
    public function __construct(SocketConfig $socketConfig)
    {
        $socketConfig->setDomain(AF_UNIX);
        parent::__construct($socketConfig);
        $this->checkDirectory();
    }

    private function checkDirectory()
    {
        if (!is_dir(dirname($this->config->getAddress()))) {
            mkdir(dirname($this->config->getAddress()));
        }
    }

    public function clearOldSocket()
    {
        if (file_exists($this->config->getAddress())) {
            unlink($this->config->getAddress());
        }
    }

    public function bind(): UnixSocket
    {
        $this->checkDirectory();
        $this->clearOldSocket();
        return parent::bind();
    }
}