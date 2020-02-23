<?php

namespace App;

/**
 * Class Client
 * @package App
 */
class Client
{

    private $isConnected = true;

    public function start()
    {
        if (file_exists(getenv('FILE_PATH_SOCKET_CLIENT'))) {
            unlink(getenv('FILE_PATH_SOCKET_CLIENT'));
        }
        $socket = new Socket(getenv('FILE_PATH_SOCKET_CLIENT'));

        $socket->create();

        $socket->bind();

        $socket->unblock();

        Message::output('The client has launched');

        Message::output('Enter the message (to exit command "close").');

        $message = $this->readInput();

        while ($this->isConnected) {
            if($message == 'close') {
                $this->isConnected = false;
                continue;
            }
            if (empty($message)) {
                Message::output('The message cannot be empty!');
                $message = $this->readInput();
                continue;
            }

            $socket->send($message, getenv('FILE_PATH_SOCKET_SERVER'));

            $socket->block();
            $bucket = $socket->receive();

            Message::output("Server:" . $bucket);

            $message = $this->readInput();
        }

        $socket->unbind();

        Message::output('The client is disconnected');

    }


    /**
     * Receiving message from console.
     *
     * @return string
     */
    private function readInput(): string
    {
        return readline('= ');
    }
}
