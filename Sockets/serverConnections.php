<?php


namespace Sockets;

class serverConnections extends serverSocket
{
    const ACCEPT_BLOCK_MODE = false;
    /**
     * Массив сокетов, с установленными соединениями с клиентами
     * @var array
     */
    private array $SocketBeans = [];
    /**
     * Указатель на завершение работы сервера
     * @var bool
     */
    private bool $stopFlag = false;

    public function start():void
    {
        // Ждем подключения и сообщения от клиентов, пока не придет команда на завершение
        do {
            // Ожидаем подключения
            if (($tmpSock = $this->socket->accept(static::ACCEPT_BLOCK_MODE))) {
                // Добавляем новое подключение в массив бинов $this->SocketBeans
                if (socket_getpeername($tmpSock, $tmpIP)) {
                    $NewSession = array_key_first($this->SocketBeans) ?? 0;
                    $NewSession++;
                    while (true) {
                        if (!isset ($this->SocketBeans[$NewSession])) {
                            $this->SocketBeans[$NewSession]['Connection'] = $tmpSock;
                            $this->SocketBeans[$NewSession]['ID'] = $NewSession;
                            socket_getpeername(
                                $this->SocketBeans[$NewSession]['Connection'],
                                $this->SocketBeans[$NewSession]['IP'],
                                $this->SocketBeans[$NewSession]['Port']
                            );
                            break;
                        } else $NewSession++;
                    }
                    $this->OnClientConnect($this->SocketBeans[$NewSession]);
                    unset ($NewSession);
                    unset ($tmpSock);
                }
            }
            // создаем массив из действующих сокетов
            $SendedMsgSockets = [];
            foreach ($this->SocketBeans as $readSock) {
                $SendedMsgSockets[] = $readSock['Connection'];
            }
            // узнаем какие сокеты что-то сказали
            $activeSocket = $this->socket->select($SendedMsgSockets);
            foreach ($activeSocket as $readSock) {
                try {
                    $this->OnReadSockets($readSock);
                    if ($this->stopFlag) {
                        exit(0);
                    }
                } catch (\Exception $exception) {
                    $id  = $this->getIdBySocket($readSock);
                    $this->closeConnection($readSock);
                    echo "Error with client number". $id .". ".$exception->getMessage() . PHP_EOL;
                }
            }
            // usleep (200000);
        } while (true);
    }

    /**
     * Закрывает соединение с клиентом
     * @param $socket
     */
    private function closeConnection($socket)
    {
        echo "Мавр" . $this->getIdBySocket($socket) . " сделал свое дело, Мавр может уходить!" . PHP_EOL;
        $this->socket->closeAcceptedSocket($socket);
        $this->deleteFromSockets($socket);
    }

    /**
     * Закрывает все соединения с клиентами
     */
    private function closeAllConnections():void
    {
        foreach ($this->SocketBeans as $socket) {
            $this->closeConnection($socket['Connection']);
        }
    }

    /**
     * Удаляет $acceptedSocket сокет, связанный с клиентом
     * @param $acceptedSocket
     */
    private function deleteFromSockets($acceptedSocket):void
    {
        $id = $this->getIdBySocket($acceptedSocket);
        if ($id) {
            unset($this->SocketBeans[$id]);
        }
    }

    /**
     * Обрабатывает входящее сообщение от клиента
     * @param $socket
     * @throws \Exception
     */
    private function OnReadSockets ($socket)
    {
        // Вызывается для работы с каждым сокетом, в котором появлиось сообщение
        // поочередно.
        $msg = $this->socket->getFromAcceptedSocket($socket);
        if ($msg) {
            echo "Client number" . $this->getIdBySocket($socket) . " says: " . $msg . PHP_EOL;
            if ($this->isDisconnectRequest($msg)) {
                $this->closeConnection($socket);
                return;
            }
            if ($this->isStopRequest($msg)) {
                $this->stopFlag = true;
                $this->socket->putToAcceptedSocket($msg, $socket);
                $this->closeAllConnections();
                $this->socket->closeSocket();
                return;
            }
        }
        $this->socket->putToAcceptedSocket($this->getMessage(), $socket);
        echo "Жду новых сообщений..." . PHP_EOL;
    }

    /**
     * Вызывается при возникновении подключения клиента
     * @param $socketBean
     */
    private function OnClientConnect ($socketBean)
    {
        // Присоединение нового клиента
        echo "Wow, I see new connection with number=". $socketBean['ID'] .". Hello my friend. What do you want to say me?\n";
    }

    /**
     * Возвращает ID Бина сокета по сокету
     * @param $socket
     * @return int
     */
    private function getIdBySocket($socket):int
    {
        return (int)array_search($socket, array_column($this->SocketBeans, 'Connection','ID'), true);
    }

    private function OnClientDisconnect ($Socket)
    {

    }

}