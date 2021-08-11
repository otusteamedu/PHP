<?php


namespace Sockets;


use Exception;


class serverSocket extends mainSocket
{
    const ACCEPT_BLOCK_MODE = true;

    /**
     * Список команд для закрытия сокета
     *
     * @var array|string[]
     */
    protected array $exitMessages = [
        'quit',
        'exit',
        'stop',
        '\q',
    ];

    /**
     * Список команд для закрытия соединения
     *
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
     *
     * @throws Exception
     */
    protected function initSocket():void
    {
        parent::initSocket();
        $this->clearOldSocket();
        $this->socket = new \Sockets\socket(
            $host = $this->host,
            $port = $this->port,
            $domain = $this->domain,
            $type = SOCK_STREAM,
            $protocol = 0,
            $maxConnection = $this->maxConnections,
            $buffer_length = $this->buffer_length,
        );
            $this->socket->create();
            $address = ($this->domain != AF_UNIX) ? $this->host : $this->path;
            $this->socket->bind($address);
            $this->socket->listen();
            echo "Сокет создан по адресу [$this->host:$this->port]\n";
    }

    /**
     * Старт работы
     *
     * @throws Exception
     */
    public function start():void
    {
        $this->socket->accept(static::ACCEPT_BLOCK_MODE);
        $this->setDialog();
    }

    /**
     * Возвращает true если $msg находится в списке команд для завершения работы
     *
     * @param string $msg
     * @return bool
     */
    protected function isStopRequest(string $msg):bool
    {
        return in_array($msg, $this->exitMessages);
    }

    /**
     * Возвращает true если $msg находится в списке команд для расставания с клиентом
     * @param string $msg
     * @return bool
     */
    protected function isDisconnectRequest(string $msg):bool
    {
        return in_array($msg, $this->disconnectMessages);
    }

    /**
     * Осуществляет диалог с клиентом через сокет
     *
     * @throws Exception
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
            } catch (Exception $exception) {
                $this->socket->closeAcceptedSocket();
                echo $exception->getMessage() . PHP_EOL;
                $this->socket->accept();
            }
        }
    }

    /**
     * Очистка предыдущего сокета
     */
    private function clearOldSocket():void
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }

}
