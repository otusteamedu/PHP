<?php

class Server {
    public $socket = null;
    private $server_file_socket = null;
    public function __construct($ini_file) {
        try {
            if(!is_readable($ini_file)) throw new Exception("INI file not exists");
            $ini = parse_ini_file($ini_file, true);
            if(!isset($ini["server"])) throw new Exception("Server config is empty");
            if(!isset($ini["server"]["socket_file"])) throw new Exception("Socket file for server is empty in config file");
            $this->server_file_socket = $ini["server"]["socket_file"];
            if(is_readable($this->server_file_socket)) unlink($this->server_file_socket);
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
        }
    }

    public function start() {
        try {
            $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
            socket_bind($this->socket, $this->server_file_socket);
            while(1) {
                if(!socket_set_block($this->socket)) {
                    throw new Exception("Unable to set blocking mode for socket");
                }
                $buf = "";
                $from = "";
                echo "Ready for receive... \n";
                $received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
                if($received == -1) throw new Exception("An error occured while receiving from the socket");
                echo "Received $buf from $from\n";
                $buf = strrev($buf);
                if(!socket_set_nonblock($this->socket)) throw new Exception("Unable to set nonblocking mode for socket");
                $len = strlen($buf);
                $sent = socket_sendto($this->socket, $buf, $len, 0, $from);
                if($sent == -1) {
                    throw new Exception("An error occured while sending to the socket");
                } else if($sent != $len) {
                    throw new Exception($sent. " bytes have been sent instead of the ".$len . "bytes excepted");
                }
                echo "Request processed\n";
            }
        }
        catch (Exception $e) {

        } finally {
            if($this->socket != null) {
                socket_close($this->socket);
            }

            unlink($this->server_file_socket);
        }


    }
}