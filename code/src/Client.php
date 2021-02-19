<?php

namespace App;

use App\Socket\Socket;

final class Client
{
    private Socket $socket;

    /**
     * Client constructor.
     * @param string $socketFile
     */
    public function __construct(string $socketFile)
    {
        $this->init($socketFile);
    }


    private function init(string $socketFile): void
    {
        $this->socket = new Socket($socketFile);
        $this->socket->create();
        $this->socket->connect();
        echo $this->socket->read(), PHP_EOL;
    }

    public function waitForMessage()
    {

        do {
            echo 'Введите сообщение: ';

            $message = $this->readLine();

            if ($message === 'c' || $message === 'q') {
                $this->message($message);
                break;
            }

            $this->message($message);

        } while(true);

        $this->socket->close();

    }

    private function waitingResponse()
    {
        echo sprintf('Ответ: "%s"', $this->socket->read()), PHP_EOL;
    }

    private function message(string $message)
    {
        $this->socket->write($message);
        $this->waitingResponse();
    }

    private function readLine(): string
    {
        return rtrim(fgets(STDIN));
    }

}
