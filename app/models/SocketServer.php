<?php

namespace models;

class SocketServer extends Socket
{

    /**
     * Initialisation for server
     *
     * @throws \Exception
     */
    protected function init()
    {
        if (file_exists($this->host)) unlink($this->host);

        if (!socket_bind($this->sock, $this->host))
            throw new \Exception("can`t bind socket".PHP_EOL);
    }

    /**
     * Run server script
     *
     * @throws \Exception
     */
    public function run()
    {
        while (true) {
            if (!socket_listen($this->sock))
                throw new \Exception("Could listen socket".PHP_EOL);

            if (($new_client = socket_accept($this->sock)) !== false)
                echo "$new_client has connected\n";

            $this->processClient($new_client);
        }
    }

    /**
     * Process client request
     * @param resource $new_client
     */
    private function processClient($new_client)
    {
        if (($input = socket_read($new_client, $this->read_length)) !== false) {
            echo "Got new message from $new_client: $input";
            $output = "Hello im Server from " . __CLASS__ . ". I got your message: $input ".PHP_EOL;
            socket_write($new_client, $output, strlen($output));
            socket_close($new_client);
        }
    }

}