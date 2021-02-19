<?php

namespace App;


use App\Socket\Socket;

final class Server
{
    private Socket $socket;
    private MessageGenerator $message;


    /**
     * Server constructor.
     * @param string $socketFile
     */
    public function __construct(string $socketFile)
    {
        $this->init($socketFile);
        $this->message = new MessageGenerator();
    }

    public function listen(): void
    {

        do {

            $this->socket->accept();

            $this->socket->writeToAccepted("\nВы подключились к серверу.\n" .
                "Чтобы отключиться, наберите 'c'. Чтобы выключить сервер, наберите 'q'.\n");

            do {
                $message = $this->socket->readFromAccepted();

                if (!$message) {
                    continue;
                }

                if ($message === 'c') {
                    $this->socket->writeToAccepted('До встречи!');
                    break;
                }

                if ($message === 'q') {
                    $this->socket->writeToAccepted('Сервер выключен!');
                    break 2;
                }

                $this->socket->writeToAccepted($this->message->getMessage());

            } while (true);

            $this->socket->close();

        } while (true);
        $this->socket->close();
    }

    private function init(string $socketFile): void
    {
        $this->socket = new Socket($socketFile);
        $this->socket->clearOldSocket();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }
}

