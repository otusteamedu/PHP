<?php


class Client {
  private $pathSocket;
  private $socket;

  function __construct($pathSocket) {
    if (!file_exists($pathSocket)) {
      throw new Exception('Does not exist socket. Please run server.');
    }

    $this->pathSocket = $pathSocket;
    $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    if ($this->socket == false) {
      throw new Exception('Can\'t create socket');
    }
    if (!socket_connect($this->socket, $this->pathSocket)) {
      throw new Exception('Can\'t connect socket');
    }
  }

  public function write($value) {
    $len = strlen($value);
    while (true) {
      $num = socket_write($this->socket, $value);
      echo $num . PHP_EOL;
      if ($num < $len) {
        $value = substr($value, $num);
        $len -= $num;
      }
      else {
        break;
      }
    }
  }

  function __destruct() {
    socket_shutdown($this->socket, 2);
    socket_close($this->socket);
  }
}
