<?php

namespace Classes;


use Throwable;

class SocketServer {


    private $domainServerSocketFilePath;
    private $maxByteForRead;
    private $protocolFamilyForSocket;
    private $typeOfDataExchange;
    private $protocol;
    private $logger;

    public function __construct(ServerSocketDataBuilder $builder, LogInterface $logger) {

        $this->domainServerSocketFilePath = $builder->getDomainServerSocketFilePath();
        $this->maxByteForRead = $builder->getMaxByteForRead();
        $this->protocolFamilyForSocket = $builder->getProtocolFamilyForSocket();
        $this->typeOfDataExchange = $builder->getTypeOfDataExchange();
        $this->protocol = $builder->getProtocol();
        $this->logger = $logger;
    }

    public function run()
    {
        $serverSocket = $this->serverUp();
        do {
            try {
                $clientSocket = $this->startConnectionWithSocket($serverSocket);
            } catch (Throwable $e) {
                echo $e->getMessage();
            }

            $this->handleClient($clientSocket);
        } while (true);
    }

    private function serverUp()
    {
        $serverSocket = null;
        try {
            $serverSocket = $this->socketCreate();
            echo "Сокет создан\n";

            $this->socketBind($serverSocket);
            echo "Сокет успешно связан с адресом\n";

            $this->socketListen($serverSocket);
            echo "Ждём подключение клиента\n";

        } catch (Throwable $e) {
            echo $e->getMessage();
        }
        return $serverSocket;
    }

    private function socketCreate() {
        $socket = socket_create($this->protocolFamilyForSocket, $this->typeOfDataExchange, $this->protocol);
        if (!$socket) {
            $this->logger->log('Ошибка создания сокета');
            throw new SocketException('Ошибка создания сокета');
        }
        return $socket;
    }


    private function socketBind($socket) {
        $bind = socket_bind($socket, $this->domainServerSocketFilePath, 0);
        if (!$bind) {
            $this->logger->log('Не получилось связать дискриптор сокета с файлом доменного сокета Unix');
            throw new SocketException('Не получилось связать дискриптор сокета с файлом доменного сокета Unix');
        }
        return $bind;
    }

    /**
     * @param $socket
     * @return bool
     * @throws SocketException
     */
    private function socketListen($socket) {
        $phone = socket_listen($socket, 1);
        if (!$phone) {
            $this->logger->log('Ошибка при попытке прослушивания сокетам');
            throw new SocketException('Ошибка при попытке прослушивания сокета');
        }
        return $phone;
    }

    /**
     * @param $socket
     * @return resource
     * @throws SocketException
     */
    private function startConnectionWithSocket($socket) {
        $socketConnection = socket_accept($socket);
        if (!$socketConnection) {
            $this->logger->log('Ошибка при старте соединений с сокетом');
            throw new SocketException('Ошибка при старте соединений с сокетом');
        }
        return $socketConnection;
    }

    private function handleClient($clientSocket) {
        $pid = pcntl_fork();

        if ($pid === -1) {
            /* fork failed */
            echo "fork failure!\n";
            die;
        }

        if ($pid === 0) {
            /* child process */
            try {
                $this->interact($this, $clientSocket);
            } catch (\Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }

        socket_close($clientSocket);
    }

    /**
     * @param SocketServer $server
     * @param $clientSocket
     * @throws SocketException
     */
    private function interact(SocketServer $server, $clientSocket) {
        $msg = 'Привет';
        $server->write($clientSocket, $msg);

        do {
            $socketReadResult = $server->read($clientSocket);

            if (!$socketReadResult) {
                echo 'Ошибка при чтении сообщения от клиента';
            }

            if ($socketReadResult === 'exit') {
                $server->socketClose($clientSocket);
                return;
            }

            if ($socketReadResult === 'Принято') {
                echo sprintf("Сообщение %s принято клиентом\n", $msg);
            }

            try {
                $msg = random_int(1, 10000);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }


            $server->write($clientSocket, $msg);
        } while (true);
    }

    private function write($socket, $msg) {
        $written = socket_write($socket, $msg, mb_strlen($msg, 'cp1251'));
        if (false === $written) {
            throw new SocketException('Ошибка при записи сообщения');
        }
        return $written;
    }

    private function read($socket) {
        $bytes = @socket_recv($socket, $message, $this->maxByteForRead, 0);
        if (false === $bytes) {
            throw new SocketException('Ошибка при чтении сообщения');
        }
        return $message;
    }

    public function socketClose($socket) {
        socket_close($socket);
        unlink($this->domainServerSocketFilePath);
    }

}
