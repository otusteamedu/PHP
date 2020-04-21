<?php

namespace Classes;

class SocketClient {

    private $domainServerSocketFilePath;
    private $domainClientSocketFilePath;
    private $maxByteForRead;
    private $protocolFamilyForSocket;
    private $typeOfDataExchange;
    private $protocol;
    private $logger;

    public function __construct(ClientSocketDataBuilder $builder, LogInterface $logger) {
        $this->domainServerSocketFilePath = $builder->getDomainServerSocketFilePath();
        $this->domainClientSocketFilePath = $builder->getDomainClientSocketFilePath();
        $this->maxByteForRead = $builder->getMaxByteForRead();
        $this->protocolFamilyForSocket = $builder->getProtocolFamilyForSocket();
        $this->typeOfDataExchange = $builder->getTypeOfDataExchange();
        $this->protocol = $builder->getProtocol();
        $this->logger = $logger;
    }

    public function socketCreate() {
        $socket = socket_create($this->protocolFamilyForSocket, $this->typeOfDataExchange, $this->protocol);
        if (!$socket) {
            $this->logger->log('Ошибка создания сокета');
            throw new SocketException('Ошибка создания сокета');
        }
        return $socket;
    }

    public function socketBind($socket) {
        $bind = socket_bind($socket, $this->domainClientSocketFilePath, 0);
        if (!$bind) {
            $this->logger->log('Не получилось связать дискриптор сокета с файлом доменного сокета Unix');
            throw new SocketException('Не получилось связать дискриптор сокета с файлом доменного сокета Unix');
        }
        return $bind;
    }

    public function read($socket) {
        $bytes = socket_recv($socket, $message, $this->maxByteForRead, 0);
        if (false === $bytes) {
            throw new SocketException('Ошибка при чтении сообщения');
        }
        return $message;
    }

    public function write($socket, $msg) {
        socket_sendto($socket, $msg,  mb_strlen($msg, 'cp1251'), 0, $this->domainServerSocketFilePath, 0);
    }

    public function socketClose($socket) {
        socket_close($socket);
    }
}

