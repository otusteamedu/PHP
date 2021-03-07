<?php


namespace Sockets;


class serverSocket extends mainSocket
{
    const ACCEPT_BLOCK_MODE = true;

    /**
     * список комманд для закрытия сокета
     * @var array|string[]
     */
    protected array $exitMessages = [
        'quit',
        'exit',
        'stop',
        '\q',
    ];

    /**
     * список комманд для закрытия соединения
     * @var array|string[]
     */
    protected array $disconnectMessages = [
        'bye',
        'Bye',
        'goodbye',
        'Goodbye',
        'GoodBye',
    ];

    /**
     * Инициализация сокета
     * @throws \Exception
     */
    protected function initSocket():void
    {
        parent::initSocket();
        $this->clearOldSocket();
        $this->socket = new \Sockets\socket(
            "$this->host",
            "$this->port",
            "$this->domain",
            SOCK_STREAM,
            0,
            "$this->maxConnections",
            "$this->buffer_length",
        );
        try {
            $this->socket->create();
            echo "Сокет создан по адресу [$this->host:$this->port]\n";
            $address = ($this->domain != AF_UNIX) ? $this->host : $this->path;
            $this->socket->bind($address);
            $this->socket->listen();
        } catch (\Exception $exception) {
            die("Error with code:" . $exception->getCode() . ". " .$exception->getMessage() . PHP_EOL);
        }
    }

    /**
     * Старт работы
     */
    public function start()
    {
        $this->socket->accept(static::ACCEPT_BLOCK_MODE);
        $this->setDialog();
    }

    /**
     * Возвращает true если $msg находится списке команд для завершения работы
     * @param string $msg
     * @return bool
     */
    protected function isStopRequest(string $msg):bool
    {
        return in_array($msg, $this->exitMessages);
    }

    /**
     * Возвращает true если $msg находится списке команд для расставания с клиентом
     * @param string $msg
     * @return bool
     */
    protected function isDisconnectRequest(string $msg):bool
    {
        return in_array($msg, $this->disconnectMessages);
    }

    /**
     * Осуществляет диалог с клиентом через сокет
     * @throws \Exception
     */
    private function setDialog():void
    {
        while (true) {
            try {
                $msg = $this->socket->getFromAcceptedSocket();
                if ($msg) {
                    echo "Client says: " . $msg . PHP_EOL;
                    if ($this->isDisconnectRequest($msg)) {
                        $this->socket->putToAcceptedSocket($msg);
                        $this->socket->closeAcceptedSocket();
                        echo "Клиент отвалился. Ожидаем нового..." . PHP_EOL;
                        $this->socket->accept();
                        continue;
                    }
                    if ($this->isStopRequest($msg)) {
                        $this->socket->putToAcceptedSocket($msg);
                        $this->socket->closeSocket();
                        exit;
                    }
                }
                $this->socket->putToAcceptedSocket($this->getMessage());
            } catch (\Exception $exception) {
                $this->socket->closeAcceptedSocket();
                echo $exception->getMessage() . PHP_EOL;
                $this->socket->accept();
            }
        }
    }


    /**
     * Очистка предыдущего сокета
     */
    private function clearOldSocket()
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
        /*if ($this->socket !== false) {
            echo "this->socket = $this->socket\n";
        }*/
    }

}