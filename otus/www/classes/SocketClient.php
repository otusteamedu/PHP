<?php

namespace Classes;

class SocketClient {

    private $domainServerSocketFilePath;
    private $maxByteForRead;
    private $protocolFamilyForSocket;
    private $typeOfDataExchange;
    private $protocol;
    private $logger;

    public function __construct(ClientSocketDataBuilder $builder, LogInterface $logger) {
        $this->domainServerSocketFilePath = $builder->getDomainServerSocketFilePath();
        $this->maxByteForRead = $builder->getMaxByteForRead();
        $this->protocolFamilyForSocket = $builder->getProtocolFamilyForSocket();
        $this->typeOfDataExchange = $builder->getTypeOfDataExchange();
        $this->protocol = $builder->getProtocol();
        $this->logger = $logger;
    }

    public function run()
    {
        $socket = $this->clientUp();
        do {
            try {
                $out = $this->read($socket);
            } catch (SocketException $e) {
                echo $e->getMessage();
            }
            echo "Сообщение от сервера: $out.\n";
            $msg = 'Принято';
            $this->write($socket, $msg);
            sleep(2);
        } while(true);
    }

    /**
     * @return false|resource
     */
    private function clientUp()
    {
        try {
            $socket = $this->socketCreate();
            echo "Сокет создан\n";

            $this->connect($socket);
            echo "Сокет успешно связан с адресом и портом\n";

            return $socket;
        } catch(SocketException $e){
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * @return false|resource
     * @throws SocketException
     */
    private function socketCreate() {
        $socket = socket_create($this->protocolFamilyForSocket, $this->typeOfDataExchange, $this->protocol);
        if (!$socket) {
            $this->logger->log('Ошибка создания сокета');
            throw new SocketException('Ошибка создания сокета');
        }
        return $socket;
    }

    /**
     * @param $socket
     * @return mixed
     * @throws SocketException
     */
    private function connect($socket) {
        $connection = socket_connect($socket, $this->domainServerSocketFilePath);
        if (!$connection) {
            $this->logger->log('Ошибка подключения');
            throw new SocketException('Ошибка подключения');
        }
        return $socket;
    }

    /**
     * @param $socket
     * @return mixed
     * @throws SocketException
     */
    private function read($socket) {
        $bytes = socket_recv($socket, $message, $this->maxByteForRead, 0);
        if (false === $bytes) {
            throw new SocketException('Ошибка при чтении сообщения');
        }
        return $message;
    }

    /**
     * @param $socket
     * @param $msg
     */
    private function write($socket, $msg) {
        socket_write($socket, $msg, mb_strlen($msg, 'cp1251'));
    }

    /**
     * @param $socket
     */
    public function socketClose($socket) {
        socket_close($socket);
    }
}

