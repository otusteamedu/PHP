<?php

class Server {
  private $pathSocket;
  private $socket;

  function __construct($pathSocket) {
    $this->pathSocket = $pathSocket;
    $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    if ($this->socket == false) {
      throw new Exception('Can\'t create socket');
    }
    if (!socket_bind($this->socket, $this->pathSocket)) {
      throw new Exception('Can\'t bind socket');
    }
    if (!socket_listen($this->socket,1)) {
      throw new Exception('Can\'t connect socket');
    }
  }

  public function read() {
    $socket = socket_accept($this->socket);
    return socket_read($socket, 1024);
  }

  function __destruct() {
    socket_shutdown($this->socket, 2);
    socket_close($this->socket);
    unlink( $this->pathSocket );
  }
}
