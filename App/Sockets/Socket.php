<?php

namespace App\Sockets;


use App\Sockets\Exceptions\SocketNotBound;
use App\Sockets\Exceptions\SocketNotConnected;
use App\Sockets\Exceptions\SocketNotCreated;
use App\Sockets\Exceptions\SocketNotListening;
use App\Sockets\Interfaces\iSocketServer;

class Socket extends AbstractSocket implements iSocketServer
{
    protected $config;
    private $maxConnections = 5;

    private $sockets = [
        'base'     => false,
        'accepted' => null
    ];

    private $states = [
        'created'   => false,
        'bound'     => false,
        'connected' => false,
        'listening' => false
    ];

    public function __construct(SocketConfig $config)
    {
        $this->config = $config;
    }

    protected function getSocket()
    {
        return $this->sockets['base'];
    }

    public function create(): Socket
    {
        if (!$this->isCreated()) {
            $this->sockets['base'] = socket_create($this->config->getDomain(), $this->config->getType(), $this->config->getProtocol());
            if ($this->sockets['base'] === false) {
                throw new SocketNotCreated();
            }
            $this->states['created'] = true;
        }
        return $this;
    }

    /**
     * @return $this
     * @throws Exceptions\SocketNotAccepted
     */
    public function accept(): Socket
    {
        $this->sockets['accepted'] = new SocketAccepted($this->sockets['base']);
        return $this;
    }


    /**
     * @return SocketAccepted
     * @throws Exceptions\SocketNotAccepted
     */
    public function accepted(): SocketAccepted
    {
        return $this->sockets['accepted'] ?? $this->accept()->sockets['accepted'];
    }

    public function bind(): Socket
    {
        if (!$this->isBound()) {
            if (socket_bind($this->sockets['base'], $this->config->getAddress(), $this->config->getPort()) === false) {
                throw new SocketNotBound();
            }
            $this->states['bound'] = true;
        }
        return $this;
    }

    public function listen(): Socket
    {
        if (!$this->isListening()) {
            if (socket_listen($this->sockets['base'], $this->getMaxConnections()) === false) {
                throw new SocketNotListening();
            }
            $this->states['listening'] = true;
        }
        return $this;
    }

    public function connect(): Socket
    {
        if (!$this->isConnected()) {
            if (socket_connect($this->sockets['base'], $this->config->getAddress(), $this->config->getPort()) === false) {
                throw new SocketNotConnected();
            }
            $this->states['connected'] = true;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxConnections(): int
    {
        return $this->maxConnections;
    }

    /**
     * @param int $maxConnections
     * @return Socket
     */
    public function setMaxConnections(int $maxConnections)
    {
        $this->maxConnections = $maxConnections;
        return $this;
    }

    public function isCreated(): bool
    {
        return $this->states['created'];
    }

    public function isConnected(): bool
    {
        return $this->states['connected'];
    }

    public function isBound(): bool
    {
        return $this->states['bound'];
    }

    public function isListening(): bool
    {
        return $this->states['listening'];
    }

    public function shutdown(int $mode = 2)
    {
        $this->resetStates();
        return parent::shutdown($mode);
    }

    public function close()
    {
        parent::close();
        $this->resetStates();
    }

    private function resetStates()
    {
        $this->states = array_fill_keys(array_keys($this->states), false);
    }
}