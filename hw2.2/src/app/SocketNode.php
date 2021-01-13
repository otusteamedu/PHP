<?php

namespace App;

use Exception;

/**
 * Class SocketNode
 * @package App
 */
class SocketNode
{
    use SocketConnectionTrait;

    /**
     * SocketNode constructor.
     * @param string $mode
     * @throws Exception
     */
    public function __construct($mode = 'server')
    {
        echo '' . $mode . PHP_EOL;
        $this->createConnection();

        if ($mode == 'server') {
            $this->bindSocket();
        }
    }

    /**
     * @throws Exception
     */
    public function useSocket()
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new Exception('Unable to set nonblocking mode for socket');
        }
    }

    public function sentData()
    {
        while (true) {
            echo 'Enter something: ';
            $msg = trim(fgets(STDIN, 1024));
            $len = strlen($msg);

            $bytesSent = socket_sendto($this->socket, $msg, $len, 0, Config::SOCKET_FILE);
            echo '> ' . $msg . PHP_EOL;
            echo 'sent: ' . $msg . PHP_EOL;
        }
    }

    /**
     * @throws Exception
     */
    public function listeningSocket()
    {
        echo 'listening ...' . PHP_EOL;
        while (true) { // server never exits
            // receive query
            if (!socket_set_block($this->socket)) {
                throw new Exception('Unable to set blocking mode for socket');
            }

            $buf = '';
            $from = '';
            echo '------------------' . PHP_EOL;
            // will block to wait client query
            $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
            if ($bytes_received == -1) {
                throw new Exception('An error occured while receiving from the socket');
            }

            echo $buf . PHP_EOL;
        }
    }
}