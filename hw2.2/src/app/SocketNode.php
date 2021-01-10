<?php

namespace App;

class SocketNode
{
    use SocketConnectionTrait;

    /**
     * SocketNode constructor.
     * @param string $mode
     */
    public function __construct($mode = 'server')
    {
        echo 'client' . PHP_EOL;

        $this->createConnection();
    }

    /**
     * @throws \Exception
     */
    public function useSocket()
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new \Exception('Unable to set nonblocking mode for socket');
        }
    }

    /**
     *
     */
    public function sentData()
    {
        while (true) {
            echo 'Enter something: ';
            $msg = trim(fgets(STDIN, 1024));
            $len = strlen($msg);

            $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, getenv('SOCKET_FILE'));
            echo '> ' . $msg . PHP_EOL;
            echo 'sent: ' . $msg . PHP_EOL;
        }
    }
}